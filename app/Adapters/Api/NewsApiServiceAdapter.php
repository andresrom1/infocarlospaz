<?php

namespace App\Adapters\Api;

use App\Adapters\WpApiPrepareData;
use ErrorException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;

class NewsApiServiceAdapter
{
    public static function getNews (array $args)
    {   
        $client = new Client();
        $headers = ['Authorization' => 'Bearer 6950a829cd8046ccabdb12b74e8d7b46'];
        $request = new Request('GET', 'http://newsapi.org/v2/top-headlines?country=ar&category=' . $args['categories'] . '&pageSize=' . $args['cantidad'], $headers);
        $res = $client->send($request);
        $responses = json_decode($res->getBody(), true);
        
        foreach($responses['articles'] as $article){
                $data = WpApiPrepareData::prepareData($article);

                ### Esta parte toma la url de la imagen y la guarda en Wordpess, obteniendo el id
                ### de la imagen guardada
                if($data['imageUrl'] != null)
                {
                    try {
                        $contents = Utils::streamFor(file_get_contents($data['imageUrl']));
                    } catch (ServerException $e) {
                        
                        echo Psr7\Message::toString($e->getRequest());
                        echo Psr7\Message::toString($e->getResponse());
                        dump('Error en el servidor al obtener la imagen destacada');
                        continue;
                    } catch (ErrorException $e){
                        dump('Error al obtener la imagen destacada');
                        continue;
                    }                 
                    $client = new Client([
                        'base_uri' => config('services.wpApiConnections.wpApi'),
                        'headers' => [
                            'Authorization' => 'Basic ' . base64_encode(config('services.wpApiConnections.wpUser') . ':' . config('services.wpApiConnections.wpAppPass')),
                            'Accept' => 'application/json',
                            'Content-type' => 'application/json',
                            'Content-Disposition' => 'attachment',
                        ]
                    ]);
                    
                    $options = [
                        'multipart' => [
                            [
                            'name' => 'file',
                            'contents' => $contents,
                            'filename' => $data['imageTitle'] . '.jpeg',
                            'title' => $data['imageTitle'] . '.jpeg',
                            'alt_text' => $data['imageTitle'] . '.jpeg',
                            'description' => $data['imageTitle'] . '.jpeg',
                            'caption' => $data['imageTitle'] . '.jpeg',
                            'headers'  => [
                                'Content-Type' => '<Content-type header>'
                                ]
                            ]
                    ]];                  
                    try {
                        $request = new Request('POST', config('services.wpApiConnections.wpApi').'media?status=publish&media_type=image');
                        $res = $client->send($request, $options);
                    } catch (ServerException $e) {                     
                        echo Psr7\Message::toString($e->getRequest());
                        echo Psr7\Message::toString($e->getResponse());
                        dump('Error en el servidor al subir a Wordpress la imagen destacada');
                        continue;
                    }catch (ClientException $e) {
                        $response = $e->getResponse();
                        $responseBodyAsString = $response->getBody()->getContents();
                        dump('Error en el cliente al subir a Wordpress la imagen destacada');
                        continue;
                    }                 
                    $response = json_decode($res->getBody(), true);
                    
                    ## Subir post
                    $created = WpApiAdapter::createPost($data,$response,$res,$args);
                    if($created == false){continue;}
                } 
        }
            return $data;
    } 

    public static function getPostFeaturedImageUrl($post)
    {
        return $post->_embedded->{"wp:featuredmedia"}[0]->source_url;
    }
}