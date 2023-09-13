<?php

namespace App\Http\View\Composers;

use App\Adapters\Api\WpApiAdapter;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;


class PostComposer
{
    public static $posts;
    public static $cat;

    public function __construct($id=null,$cat=null)
    {  
        self::$posts = []; 
        self::getPosts($id,$cat);  
        self::$cat = $cat;   
        
    }

    public static function compose(View $view)
    {
        $view->with('posts',self::$posts);
    }

    Public static function getPosts($id,$cat)
    {   
        $i=0;
        $array=[];
        $catArray=[];
        
        if ($id==null && $cat==null) {
            $p = WpApiAdapter::getPosts();
        } elseif ($id){
            $p = WpApiAdapter::getPostsById($id);
        } elseif ($cat) {
            $p = WpApiAdapter::getPostsByCategory($cat);
        } else {
            dd('Error al determinar si hay Id o Categoría');
        }
        foreach($p as $raw)
        {      
            $array = Arr::add( $array, 'id', $raw->id);
            $array = Arr::add( $array, 'status', $raw->status);
            $array = Arr::add( $array, 'date', Carbon::parse($raw->date)->diffForHumans());
            $array = Arr::add( $array, 'link', $raw->link);
            $array = Arr::add( $array, 'title', Str::remove(['<p>','</p>','<br />'],$raw->title->rendered));
            $array = Arr::add( $array, 'content', Str::remove(['<p>','</p>','<br />'],$raw->content->rendered));
            $array = Arr::add( $array, 'featuredMediaId', $raw->featured_media);
            $array = Arr::add( $array, 'featuredMedia', $raw->_embedded->{"wp:featuredmedia"}[0]->source_url);
            $j=0;
            foreach ($raw->categories as $value) {
                $category = WpApiAdapter::getCategory($value);
                $catArray = Arr::add($catArray,$value,$category);
                $j++;              
            }
            $array = Arr::add ( $array, 'categories', $catArray);       
            self::$posts = Arr::add( self::$posts,$i,$array);
            $catArray = [];
            $array = [];
            $i++;
        }
        return self::$posts;
    }
}