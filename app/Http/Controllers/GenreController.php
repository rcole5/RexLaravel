<?php

namespace App\Http\Controllers;

use \App\Models\Genre;
use App\Transformers\GenreTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

/**
 * Class GenreController
 * @package App\Http\Controllers
 */
class GenreController extends Controller
{
    /**
     * Returns all genres.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $fractal = new Manager();
        $genre = Genre::all();
        $resource = new Collection($genre, new GenreTransformer());
        return response($fractal->createData($resource)->toJson(), 200);
    }

    /**
     * Returns specific genre.
     *
     * @param Genre $genre
     * @return Genre
     */
    public function show(Genre $genre)
    {
        $fractal = new Manager();
        $resource = new Item($genre, new GenreTransformer());
        return response($fractal->createData($resource)->toJson(), 200);
    }

    /**
     * Creates a genre.
     *
     * @param Request $r
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $r)
    {
        $fractal = new Manager();
        $genre = Genre::create($r->all());
        $resource = new Item($genre, new GenreTransformer());
        return response($fractal->createData($resource)->toJson(), 201);
    }

    /**
     * Updates a genre.
     *
     * @param Request $r
     * @param Genre $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $r, Genre $genre)
    {
        $fractal = new Manager();
        $genre->update($r->all());
        $resource = new Item($genre, new GenreTransformer());
        return response($fractal->createData($resource)->toJson(), 200);
    }

    /**
     * Deletes a genre.
     *
     * @param Genre $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Genre $genre)
    {
        $genre->delete();
        return response()->json(null, 204);
    }

    public function movies(Genre $genre)
    {
        $fractal = new Manager();
        $resource = new Collection($genre->movies, function($movie) {
           return [
               'id' => (int) $movie->id,
               'title' => $movie->title,
               'description' => $movie->description,
               'rating' => $movie->rating,
               'image' => $movie->image,
           ];
        });
        return response($fractal->createData($resource)->toJson(), 200);
//        return response($genre->movies, 200);
//        return $genre->movies;
    }
}
