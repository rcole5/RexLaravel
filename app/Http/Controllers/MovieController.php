<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Transformers\MovieTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

/**
 * Class MovieController
 * @package App\Http\Controllers
 */
class MovieController extends Controller
{
    /**
     * Returns all movies.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $fractal = new Manager();
        $movie = Movie::all();
        $resource = new Collection($movie, new MovieTransformer());
        return response($fractal->createData($resource)->toJson(), 200);
    }

    /**
     * Returns a specific movie.
     *
     * @param Movie $movie
     * @return Movie
     */
    public function show(Movie $movie)
    {
        $fractal = new Manager();
        $resource = new Item($movie, new MovieTransformer());
        return response($fractal->createData($resource)->toJson(), 200);
    }

    /**
     * Creates a movie.
     *
     * @param Request $r
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $r)
    {
        $fractal = new Manager();
        $movie = Movie::create($r->all());
        $resource = new Item($movie, new MovieTransformer());
        return response($fractal->createData($resource)->toJson(), 201);
    }

    /**
     * Updates a movie.
     *
     * @param Request $r
     * @param Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $r, Movie $movie)
    {
        $fractal = new Manager();
        $movie->update($r->all());
        $resource = new Item($movie, new MovieTransformer());
        return response($fractal->createData($resource)->toJson(), 200);
    }

    /**
     * Deletes a movie.
     *
     * @param Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Movie $movie)
    {
        $movie->delete();
        return response()->json(null, 204);
    }
}
