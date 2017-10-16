<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 8/10/2017
 * Time: 9:15 PM
 */

namespace App\Transformers;


use App\Models\Actor;
use League\Fractal\TransformerAbstract;

class ActorTransformer extends TransformerAbstract
{
    public function transform(Actor $actor)
    {
        return [
            'id' => (int)$actor['id'],
            'name' => $actor['name'],
            'dob' => $actor['dob'],
            'age' => (int) $actor['age'],
            'bio' => $actor['bio'],
            'image' => $actor['image'],
        ];
    }
}