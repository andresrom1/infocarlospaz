<?php

namespace App\Adapters\Api;

use App\Contracts\WpApiInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class WpApiAdapter implements WpApiInterface
{
    
    public static function createPost($data,$response,$res,$args)
    {
        $client = new Client([
            'base_uri' => config('services.wpApiConnections.wpApi'),
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(config('services.wpApiConnections.wpUser') . ':' . config('services.wpApiConnections.wpAppPass')),
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Content-Disposition' => 'attachment',
            ]
        ]);     
            try {
                $request =  $client->request('POST', config('services.wpApiConnections.wpApi').'posts?' . 
                    'title=' . $data['postTitle'] . 
                    '&content=' . $data['postDescription'] . "<br/>" . $data['postContent'] . "<br/><p>Leé la nota completa en: <a href=".$data['postUrl'].">" . $data['postUrl'] . "</a></p>" .
                    '&excerpt=' . $data['postDescription'] .
                    '&author=1' .
                    '&categories=' . $args['categoryId'] .
                    '&status=publish' .
                    '&featured_media=' . $response['id']);
                
                $response = json_decode($res->getBody(), true);

            } catch (ServerException $e) {
                
                echo Psr7\Message::toString($e->getRequest());
                echo Psr7\Message::toString($e->getResponse());
                return false;
            }catch (ClientException $e) {
                $response = $e->getResponse();
                $responseBodyAsString = $response->getBody()->getContents();
                return false;
            }
            return true;
    }
    public static function getPosts()
    {
        $client = new Client([
            'base_uri' => config('services.wpApiConnections.wpApi'),
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(config('services.wpApiConnections.wpUser') . ':' . config('services.wpApiConnections.wpAppPass')),
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Content-Disposition' => 'attachment',
            ]
        ]);
        try {
            $request = new Request('GET', config('services.wpApiConnections.wpApi').'posts?_embed&status=publish,draft&per_page=8');   
        } catch (\GuzzleHttp\Exception\RequestException $ex) {
             return $ex->getResponse()->getBody()->getContents(); 
             // you can even json_decode the response like json_decode($ex->getResponse()->getBody()->getContents(), true)    
        }
        return collect(json_decode($client->send($request)->getBody()));
        
    }

    public static function getPostsById($postId)
    {
        $client = new Client([
            'base_uri' => config('services.wpApiConnections.wpApi'),
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(config('services.wpApiConnections.wpUser') . ':' . config('services.wpApiConnections.wpAppPass')),
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Content-Disposition' => 'attachment',
            ]
        ]);
        $request = new Request('GET', config('services.wpApiConnections.wpApi').'posts?_embed&status=any&include='.$postId.'&');
        return collect(json_decode($client->send($request)->getBody()));
    }

    public static function getPostsByCategory($cat)
    {
        $catId= WpApiadapter::getCategoryByName($cat);
        $client = new Client([
            'base_uri' => config('services.wpApiConnections.wpApi'),
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(config('services.wpApiConnections.wpUser') . ':' . config('services.wpApiConnections.wpAppPass')),
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Content-Disposition' => 'attachment',
            ]
        ]);
        $request = new Request('GET', config('services.wpApiConnections.wpApi').'posts?_embed&status=any&categories='.$catId.'&');
        return collect(json_decode($client->send($request)->getBody()));
    }
    
    public static function getCategory ($id)
    {
        try {
            $client = new Client();
            $endpoint = config('services.wpApiConnections.wpApi')."categories/".$id;
            $request = new Request('GET', $endpoint);

            $categories = collect(json_decode($client->send($request)->getBody()));
            return $categories['name'];

        } catch (ServerException $e) {
            
            echo Psr7\Message::toString($e->getRequest());
            echo Psr7\Message::toString($e->getResponse());
            return "e Server";
        
        }catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return "e Cliente";
        }
    }

    public static function getCategoryByName ($cat)
    {
        try {
            $client = new Client();
            $endpoint = config('services.wpApiConnections.wpApi')."categories/";
            $request = new Request('GET', $endpoint);

            $categories = collect(json_decode($client->send($request)->getBody()));

            foreach ($categories as $category) {
                if($category->slug == $cat)
                {
                    return $category->id;
                } 
            }
            dd('Fallo al obtener la categoría por Nombre');
        } catch (ServerException $e) {
            
            echo Psr7\Message::toString($e->getRequest());
            echo Psr7\Message::toString($e->getResponse());
            return "e Server";
        
        }catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return "e Cliente";
        }
    }

    /**
     * Devuelve una coleccion de las Categorías con su ID
     *  $categories->id;
     *  $categories->name;
     */
    public static function getCategoryList ()
    {
        try {
            $client = new Client();
            $endpoint = config('services.wpApiConnections.wpApi')."categories/";
            $request = new Request('GET', $endpoint);

            $categories = collect(json_decode($client->send($request)->getBody()));
            return $categories;

        } catch (ServerException $e) {
            
            echo Psr7\Message::toString($e->getRequest());
            echo Psr7\Message::toString($e->getResponse());
            return "e Server";
        
        }catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return "e Cliente";
        }
    }

    public static function isDestacado($post)
    {
        foreach ($post['categories'] as $categoryId => $categoryName)
        {
            $destacado = false;
            if($categoryName == "Destacadas")
            {
                return true;       
            } 
        }

        return false;
    }

    public static function updatePostDestacado($post)
    {
        $client = new Client([
            'base_uri' => config('services.wpApiConnections.wpApi'),
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(config('services.wpApiConnections.wpUser') . ':' . config('services.wpApiConnections.wpAppPass')),
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Content-Disposition' => 'attachment',
            ]
        ]);
        
        if(Arr::exists($post['categories'], '3')){

            $array= Arr::pull($post['categories'],'3');

        } else {

            $post['categories'] = Arr::prepend($post['categories'],'Destacadas','3');

        }
        $strCategories = collect(array_keys($post['categories']))->implode(',');
        try {
            $client->request('POST', config('services.wpApiConnections.wpApi').'posts/'.$post['id'].'?' . 
                '&categories=' . $strCategories);
           
        
        } catch (ServerException $e) {
            
            echo Psr7\Message::toString($e->getRequest());
            echo Psr7\Message::toString($e->getResponse());
    
        }catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
        }        
    }

    public static function draftPost($post)
    {
           $client = new Client([
            'base_uri' => config('services.wpApiConnections.wpApi'),
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(config('services.wpApiConnections.wpUser') . ':' . config('services.wpApiConnections.wpAppPass')),
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Content-Disposition' => 'attachment',
            ]
        ]);

        try {
            if ($post['status']=='publish') {
                $client->request('POST', config('services.wpApiConnections.wpApi'). 'posts/' .$post['id'] .'?' . 
                'status=draft');
            
            } else {
                $client->request('POST', config('services.wpApiConnections.wpApi'). 'posts/' .$post['id'] .'?' . 
                'status=publish');
            }
            
           
        
        } catch (ServerException $e) {
            
            echo Psr7\Message::toString($e->getRequest());
            echo Psr7\Message::toString($e->getResponse());
    
        }catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

        }        

    }

}