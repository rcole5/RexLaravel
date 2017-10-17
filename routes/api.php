<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

// Requires API token to access.
Route::group(['middleware' => 'auth:api'], function(){
    // Actor Group.
    Route::prefix('actor')->group(function() {
        // Create new actor.
        Route::post('/', 'ActorController@store');
        // Get all actors.
        Route::get('/', 'ActorController@index');
        // Get latest actors.
        Route::get('/latest', 'ActorController@getLatest');
        // Get certain actor.
        Route::get('/{actor}', 'ActorController@show');
        // Update an actor.
        Route::put('/{actor}', 'ActorController@update');
        // Delete an actor.
        Route::delete('/{actor}', 'ActorController@delete');

        /* ACTOR GENRE ROUTES */
        // Return all genres.
        Route::get('/{actor}/genre', 'ActorGenreController@index');
        // Add genre to actor.
        Route::post('/{actor}/genre', 'ActorGenreController@create');
        // Remove genre from actor.
        Route::delete('/{actor}/genre/{genre}', 'ActorGenreController@delete');
        // Remove all genres from actor.
        Route::delete('/{actor}/genre/', 'ActorGenreController@deleteAll');
    });

    // Movie Group.
    Route::prefix('movie')->group(function () {
        // Create new movie.
        Route::post('/', 'MovieController@store');
        // Get all movies.
        Route::get('/', 'MovieController@index');
        // Get latest movies.
        Route::get('/latest', 'MovieController@getLatest');
        // Get certain movie.
        Route::get('/{movie}', 'MovieController@show');
        // Update a movie.
        Route::put('/{movie}', 'MovieController@update');
        // Delete a movie.
        Route::delete('/{movie}', 'MovieController@delete');

        /* MOVIE GENRE ROUTES */
        // Return all genres.
        Route::get('/{movie}/genre', 'MovieGenreController@index');
        // Add genre to movie.
        Route::post('/{movie}/genre/', 'MovieGenreController@create');
        // Remove genre from movie.
        Route::delete('/{movie}/genre/{genre}', 'MovieGenreController@delete');
        // Remove all genres from movie.
        Route::delete('/{movie}/genre/', 'MovieGenreController@deleteAll');

        /* MOVIE ACTOR ROUTES */
        // Return all actors in a movie.
        Route::get('/{movie}/actor', 'ActorMovieController@index');
        // Add actor to a movie.
        Route::post('/{movie}/actor', 'ActorMovieController@create');
        // Delete an actor from a movie.
        Route::delete('/{movie}/actor/{actor}', 'ActorMovieController@delete');
        // Delete all actors from a movie.
        Route::delete('/{movie}/actor', 'ActorMovieController@deleteAll');
    });

    // Genre Group.
    Route::prefix('genre')->group(function () {
        // Create new genre.
        Route::post('/', 'GenreController@store');
        // Get all genres.
        Route::get('/', 'GenreController@index');
        // Get certain genre.
        Route::get('/{genre}', 'GenreController@show');
        // Update a genre.
        Route::put('/{genre}', 'GenreController@update');
        // Delete a genre.
        Route::delete('/{genre}', 'GenreController@delete');

        /* MOVIES IN GENRE */
        Route::get('/{genre}/movies', 'GenreController@movies');

        /* ACTORS IN GENRE */
        Route::get('/{genre}/actors', 'GenreController@actors');
    });
});

// Register a user.
Route::post('/register', 'Auth\RegisterController@register');
// Login a user.
Route::post('/login', 'Auth\LoginController@login');
// Logout a user.
Route::post('logout', 'Auth\LoginController@logout');
