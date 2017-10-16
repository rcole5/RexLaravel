<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Movie;
use App\User;
use Tests\TestCase;

/**
 * Class MovieGenreTest
 * @package Tests\Feature
 */
class MovieGenreTest extends TestCase
{

    /**
     * Test adding a genre to a movie.
     *
     * @return void
     */
    public function testAddGenreToMovie()
    {
        $movie = factory(Movie::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'sci-fi']);

        $movie->genres()->attach($genre->id);

        $this->assertTrue('sci-fi' == $movie->genres[0]->name);
    }

    /**
     * Test adding multiple genres to a movie.
     *
     * @return void
     */
    public function testAddMultipleGenreToMovie()
    {
        $movie = factory(Movie::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'sci-fi']);
        $genre2 = factory(Genre::class)->create(['name' => 'action']);

        $movie->genres()->attach($genre->id);
        $movie->genres()->attach($genre2->id);

        $this->assertTrue('sci-fi' == $movie->genres[0]->name);
        $this->assertTrue('action' == $movie->genres[1]->name);
    }

    /**
     * Test removing a genre from a movie.
     *
     * @return void
     */
    public function testRemoveGenreFromMovie()
    {
        $movie = factory(Movie::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'sci-fi']);

        $movie->genres()->attach($genre->id);
        $movie->genres()->detach($genre->id);

        $this->assertTrue(0 == count($movie->genres));
    }

    /**
     * Test removing all genres from a movie.
     *
     * @return void
     */
    public function testRemoveAllGenreFromMovie()
    {
        $movie = factory(Movie::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'sci-fi']);
        $genre2 = factory(Genre::class)->create(['name' => 'action']);

        $movie->genres()->attach($genre->id);
        $movie->genres()->attach($genre2->id);

        $movie->genres()->detach();

        $this->assertTrue(0 == count($movie->genres));
    }

    /**
     * Test get movie genres.
     *
     * @return void
     */
    public function testGetMovieGenres()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $movie = factory(Movie::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'sci-fi']);
        $genre2 = factory(Genre::class)->create(['name' => 'action']);

        $movie->genres()->attach($genre->id);
        $movie->genres()->attach($genre2->id);
        $this->json('GET', '/api/movie/' . $movie->id . '/genre', [], $headers)
            ->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'id' => $genre->id,
                    'genre' => $genre->name,
                ],
                [
                    'id' => $genre2->id,
                    'genre' => $genre2->name,
                ]
            ]
            ]);
    }

    /**
     * Test adding genre to movie.
     *
     * @return void
     */
    public function testAddMovieGenre()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $movie = factory(Movie::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'action']);

        $payload = [
            'genre_id' => $genre->id
        ];

        $this->json('POST', '/api/movie/' . $movie->id . '/genre/', $payload, $headers)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'action'
                ],
            ]);
    }

    /**
     * Test delete genres from movie.
     *
     * @return void
     */
    public function testDeleteMovieGenre()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $movie = factory(Movie::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'action']);

        $payload = [
            'genre_id' => $genre->id
        ];

        // Add genre to delete.
        $this->json('POST', '/api/movie/' . $movie->id . '/genre/', $payload, $headers)
            ->assertStatus(201);

        // Delete the genre.
        $this->json('DELETE', '/api/movie/' . $movie->id . '/genre/' . $genre->id, [], $headers)
            ->assertStatus(204);
    }

    /**
     * Test deleting all genres.
     *
     * @return void
     */
    public function testDeleteAllMovieGenres()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $movie = factory(Movie::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'action']);
        $genre2 = factory(Genre::class)->create(['name' => 'sci-fi']);

        $payload = [
            'genre_id' => $genre->id
        ];

        $payload2 = [
            'genre_id' => $genre2->id
        ];

        // Add genre to delete.
        $this->json('POST', '/api/movie/' . $movie->id . '/genre/', $payload, $headers)
            ->assertStatus(201);

        $this->json('POST', '/api/movie/' . $movie->id . '/genre/', $payload2, $headers)
            ->assertStatus(201);

        // Delete the genre.
        $this->json('DELETE', '/api/movie/' . $movie->id . '/genre/' . $genre->id, [], $headers)
            ->assertStatus(204);
    }
}
