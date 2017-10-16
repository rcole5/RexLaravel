<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 8/10/2017
 * Time: 9:38 PM
 */

namespace App\Transformers;


use App\Models\Genre;
use League\Fractal\TransformerAbstract;

class GenreTransformer extends TransformerAbstract
{
    public function transform(Genre $genre)
    {
        return [
            'id' => (int) $genre['id'],
            'name' => $genre['name'],
        ];
    }
}