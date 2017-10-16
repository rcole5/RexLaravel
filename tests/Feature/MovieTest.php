<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Movie;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class MovieTest
 * @package Tests\Feature
 */
class MovieTest extends TestCase
{
    /**
     * Tests if movie list is returned.
     *
     * @return void
     */
    public function testGetMovie()
    {
        // Creates user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', '/api/movie', [], $headers)
            ->assertStatus(200);
    }

    /**
     * Tests if movie is created successfully.
     *
     * @return void
     */
    public function testCreateMovie()
    {
        // Creates user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'title' => 'movie title',
            'rating' => 8.98,
            'description' => 'A very good movie.',
            'image' => null,
        ];

        $this->json('POST', '/api/movie', $payload, $headers)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'movie title',
                    'rating' => 8.98,
                    'description' => 'A very good movie.'
                ],
            ]);
    }

    /**
     * Tests if movie is updated successfully.
     *
     * @return void
     */
    public function testUpdateMovie()
    {
        // Creates user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Create Movie
        $movie = factory(Movie::class)->create();

        // Set payload for updating.
        $payload = [
            'title' => 'The Best Movie',
        ];

        // Test the update.
        $this->json('PUT', '/api/movie/' . $movie->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'The Best Movie'
                ],
            ]);
    }

    /**
     * Tests if movie is deleted.
     *
     * @return void
     */
    public function testDeleteMovie()
    {
        // Creates user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Create Movie
        $movie = factory(Movie::class)->create();

        $movieId = $movie->id;

        // Test deleting movie.
        $this->json('DELETE', '/api/movie/' . $movie->id, [], $headers)
            ->assertStatus(204);

        // Test movie was deleted.
        $this->assertEquals(null, Movie::find($movieId));
    }

    /**
     * Tests getting a single movie.
     *
     * @return void
     */
    public function testShowMovie()
    {
        // Creates user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Create Movie
        $movie = factory(Movie::class)->create([
            'title' => 'movie title',
            'rating' => 8.98,
            'description' => 'A very good movie.',
            'image' => null,
        ]);

        $genre = factory(Genre::class)->create(['name' => 'sci-fi']);

        $movie->genres()->attach($genre->id);

        $this->json('GET', '/api/movie/' . $movie->id, [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'movie title',
                    'rating' => 8.98,
                    'description' => 'A very good movie.',
                ],
            ]);
    }
}
