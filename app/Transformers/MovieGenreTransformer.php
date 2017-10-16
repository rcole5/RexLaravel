<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 10/10/2017
 * Time: 11:09 PM
 */

namespace App\Transformers;


class MovieGenreTransformer
{
    public function transform($genre)
    {
        return [
            'id' => (int)$genre['id'],
            'genre' => $genre['name'],
        ];
    }
}