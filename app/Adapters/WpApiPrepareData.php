<?php

namespace App\Adapters;

use App\Adapters\Api\NewsApiServiceAdapter;
use App\Contracts\NewsInterface;
use Illuminate\Support\Collection;

class WpApiPrepareData
{
    public static function prepareData($article)
    {
        $data = [
            'postTitle' => $article['title'],
            'postDescription' => $article['description'],
            'postContent' => $article['content'],
            'postUrl' => $article['url'],
            'postPublishedAt' => $article['publishedAt'],
            'postDescription' => $article['description'],
            'imageTitle' => $article['title'],
            'imageUrl' => $article['urlToImage'],
        ];

        return $data;

    }
}

