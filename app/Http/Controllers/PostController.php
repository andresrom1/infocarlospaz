<?php

namespace App\Http\Controllers;

use App\Adapters\Api\WpApiAdapter;
use App\Adapters\ApiSelectorService;
use App\Http\View\Composers\PostComposer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class PostController extends Controller
{
    public function index($cat=null)
    {   
        return view('dashboard', compact('cat'));
    }

    public function index2 ()
    {   
        return view('dashboard2');
    }
    
    public function update($postId)
    {
        $posts=PostComposer::getPosts($postId,$cat=null);

        foreach ($posts as $post) {
            WpApiAdapter::updatePostDestacado($post);
        }

        return redirect('/dashboard');

    }
    public function destroy($postId)
    {
        dump(URL::previous());
        $posts=PostComposer::getPosts($postId,$cat=null);
        foreach ($posts as $post) {
            
            WpApiAdapter::draftPost($post);
        }

        return redirect('/dashboard');

    }

    public function filter($cat)
    {      
        $posts=PostComposer::getPosts($postId=null,$cat);
        return view('/dashboard', compact('posts'));
    }
    
    public function toPost()
    {
        $args = [];
        $data = ApiSelectorService::getNews("newsapi", $args);
        return redirect('/dashboard');
    }

    public function create()
    {
        return view('post.create');
    }

    public function store()
    {
        $args = request()->validate([
            'categories'=>'required',
            'cantidad' => 'required'
        ]);
        $categories = WpApiAdapter::getCategoryList();

        foreach ($categories as $key => $value) {
            
            if ($args['categories'] == 'science') {            
                if ($value->name == "Ciencia") {
                    $args['categoryId']= $value->id;
                }             
            } elseif ($args['categories'] == 'sports') {
                if ($value->name == "Deportes") {
                    $args['categoryId']= $value->id;
                }
            } elseif ($args['categories'] == 'technology') {
                if ($value->name == "Tecnología") {
                    $args['categoryId']= $value->id;
                }
            } elseif ($args['categories'] == 'health') {
                if ($value->name == "Salud") {
                    $args['categoryId']= $value->id;
                }
            } elseif ($args['categories'] == 'entertainment') {
                if ($value->name == "Entretenimiento") {
                    $args['categoryId']= $value->id;
                }
            } elseif ($args['categories'] == 'general') {
                if ($value->name == "Política") {
                    $args['categoryId']= $value->id;
                }
            } elseif ($args['categories'] == 'business') {
                if ($value->name == "Economía") {
                    $args['categoryId']= $value->id;
                }
            } 
        }
        $data=ApiSelectorService::getNews("newsapi", $args);
        return redirect('dashboard');

    }
}
