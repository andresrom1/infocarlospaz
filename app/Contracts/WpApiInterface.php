<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface WpApiInterface {

    public static function getPosts();
    public static function getCategory ($id);
    public static function isDestacado ($post);
    public static function updatePostDestacado($post);
    
}