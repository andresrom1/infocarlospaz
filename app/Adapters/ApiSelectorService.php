<?php

namespace App\Adapters;

use App\Adapters\Api\NewsApiServiceAdapter;
use App\Contracts\NewsInterface;
use Illuminate\Support\Collection;

class ApiSelectorService implements NewsInterface
{
    public static function getNews (string $servicio, array $args) 
    {
        if ($servicio == "newsapi"){
            $data = NewsApiServiceAdapter::getNews($args);
            //hacer esto
            return $data;
        } elseif ( $servicio == "otraapi") {
            
            return null;
        
        } else {

            return null;
        }
    }

    public static function getPostFeaturedImageUrl($post)
    {
        $featuredImageUrl = NewsApiServiceAdapter::getPostFeaturedImageUrl($post);

        return $featuredImageUrl;
    }
}