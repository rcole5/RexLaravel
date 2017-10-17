<?php

namespace App\Http\Controllers;

use \App\Models\Movie;
use \App\Models\Genre;
use App\Transformers\MovieGenreTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

/**
 * Class MovieGenreController
 * @package App\Http\Controllers
 */
class MovieGenreController extends Controller
{
    /**
     * Returns all genres from that movie.
     *
     * @param Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Movie $movie)
    {
        $fractal = new Manager();
        $resource = new Collection($movie->genres, function ($genres) {
            return [
                'id' => (int)$genres['id'],
                'genre' => $genres['name'],
            ];
        });
        return response($fractal->createData($resource)->toJson(), 200);
    }

    /**
     * Adds a genre to a movie.
     *
     * @param Request $r
     * @param Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $r, Movie $movie)
    {
        $fractal = new Manager();
        $movie->genres()->attach($r->input('genre_id'));
        $resource = new Item($movie->genres, function ($x) {
            $latest = $x[count($x) - 1];
            return [
                'id' => $latest->id,
                'name' => $latest->name,
            ];
        });
        return response($fractal->createData($resource)->toJson(), 201);
    }

    /**
     * Remove a genre from a movie.
     *
     * @param Movie $movie
     * @param Genre $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Movie $movie, Genre $genre)
    {
        $movie->genres()->detach($genre->id);
        return response()->json(null, 204);
    }

    /**
     * Remove all genres from a movie.
     *
     * @param Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAll(Movie $movie)
    {
        $movie->genres()->detach();
        return response()->json(null, 204);
    }
}
