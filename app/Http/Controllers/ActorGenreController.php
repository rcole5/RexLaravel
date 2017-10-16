<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Genre;
use App\Transformers\ActorGenreTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

/**
 * Class ActorGenreController
 * @package App\Http\Controllers
 */
class ActorGenreController extends Controller
{
    /**
     * Return all Actor genres.
     *
     * @param Actor $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Actor $actor)
    {
        $fractal = new Manager();
//        $resource = new Collection($actor->genres, new ActorGenreTransformer());
        $resource = new Collection($actor->genres, function($genre) {
            return [
                'id' => $genre->id,
                'genre' => $genre->name,
            ];
        });
        return response($fractal->createData($resource)->toJson(), 200);
    }

    /**
     * Add a genre to an Actor.
     *
     * @param Request $r
     * @param Actor $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $r, Actor $actor, Genre $genre)
    {
        $fractal = new Manager();
        $actor->genres()->attach($genre->id);
        $resource = new Item($actor, new ActorGenreTransformer());
        return response($fractal->createData($resource)->toJson(), 201);
    }

    /**
     * Delete a genre from an Actor.
     *
     * @param Actor $actor
     * @param Genre $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Actor $actor, Genre $genre)
    {
        $actor->genres()->detach($genre->id);
        return response()->json(null, 204);
    }

    /**
     * Delete all genres from an Actor.
     *
     * @param Actor $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAll(Actor $actor)
    {
        $actor->genres()->detach();
        return response()->json(null, 204);
    }
}
