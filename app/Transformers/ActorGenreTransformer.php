<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 8/10/2017
 * Time: 9:52 PM
 */

namespace App\Transformers;


use App\ActorGenre;
use App\Models\Actor;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;

class ActorGenreTransformer extends TransformerAbstract
{
    public function transform(Actor $actor)
    {
        $arr = Array();
        foreach ($actor->genres as $genre) {
            array_push($arr, $genre['name']);
        }

        return [
            'genres' => $arr,
        ];
    }
}