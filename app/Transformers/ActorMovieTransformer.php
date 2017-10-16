<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 10/10/2017
 * Time: 1:49 PM
 */

namespace App\Transformers;


use App\Models\Actor;
use App\Models\Movie;

class ActorMovieTransformer
{
    public function transform($movie)
    {
//        foreach ($movie->actors as $actor) {
//            array_push($arr, $actor->name);
//        }
//        return $arr;
        return [
            'id' => (int) $movie['id'],
            'name' => $movie['name']
        ];
    }
}