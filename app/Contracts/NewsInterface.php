<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface NewsInterface {

    public static function getNews (string $servicio, array $args);
    public static function getPostFeaturedImageUrl($post);
    
}