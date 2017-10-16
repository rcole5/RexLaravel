<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 8/10/2017
 * Time: 9:25 PM
 */

namespace App\Transformers;


use App\Models\Movie;
use League\Fractal\TransformerAbstract;

class MovieTransformer extends TransformerAbstract
{
    public function transform(Movie $movie)
    {
        return [
            'id' => (int) $movie['id'],
            'title' => $movie['title'],
            'rating' => (double) $movie['rating'],
            'description' => $movie['description'],
            'image' => $movie['image'],
            'created_at' => $movie['created_at'],
        ];
    }
}