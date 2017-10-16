<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Movie;
use App\Transformers\ActorMovieTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

/**
 * Class ActorMovieController
 * @package App\Http\Controllers
 */
class ActorMovieController extends Controller
{
    /**
     * Get all movie actors.
     *
     * @param Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Movie $movie)
    {
        $fractal = new Manager();
        $resource = new Collection($movie->actors, function ($x) {
            return [
                'id' => $x->id,
                'actor_name' => $x->name,
                'character_name' => $x->pivot->character_name,
            ];

        });
        return response($fractal->createData($resource)->toJson(), 200);
    }

    /**
     * Add an actor to a movie.
     *
     * @param Request $r
     * @param Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $r, Movie $movie)
    {
        $fractal = new Manager();
        $movie->actors()->attach($r->input('actor_id'),
            ['character_name' => $r->input('character_name')]);

        $resource = new Item($movie, function (Movie $x) {
            $new = $x->actors[count($x->actors) - 1];
            return [
                'id' => $new->id,
                'actor_name' => $new->name,
                'character_name' => $new->pivot->character_name,
            ];

        });

        return response($fractal->createData($resource)->toJson(), 201);
    }

    /**
     * Remove an actor form a movie.
     *
     * @param Movie $movie
     * @param Actor $actor
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Movie $movie, Actor $actor)
    {
        $movie->actors()->detach($actor->id);
        return response()->json(null, 204);
    }

    /**
     * Remove all actors from a movie.
     *
     * @param Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAll(Movie $movie)
    {
        $movie->actors()->detach();
        return response()->json(null, 204);
    }
}
