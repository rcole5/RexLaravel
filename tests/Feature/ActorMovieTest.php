<?php

namespace Tests\Feature;

use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ActorMovieTest
 * @package Tests\Feature
 */
class ActorMovieTest extends TestCase
{
    /**
     * Test get all movie actors.
     *
     * @return void
     */
    public function testGetMovieActors()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $movie = factory(Movie::class)->create();

        $this->json('GET', '/api/movie/' . $movie->id . '/actor', [], $headers)
            ->assertStatus(200);
    }

    /**
     * Test adding actor to a movie.
     *
     * @return void
     */
    public function testAddActorMovie()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $movie = factory(Movie::class)->create();
        $actor = factory(Actor::class)->create();

        $payload = [
            'actor_id' => $actor->id,
            'character_name' => 'test'
        ];

        $this->json('POST', '/api/movie/' . $movie->id . '/actor', $payload, $headers)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => $actor->id,
                    'actor_name' => $actor->name,
                    'character_name' => $payload['character_name'],
                ],
            ]);
    }

    /**
     * Test deleting actor form a movie.
     *
     * @return void
     */
    public function testDeleteActorMovie()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $actor = factory(Actor::class)->create();
        $movie = factory(Movie::class)->create();

        $payload = [
            'actor_id' => $actor->id,
            'character_name' => 'test'
        ];

        // Add actor to delete.
        $this->json('POST', '/api/movie/' . $movie->id . '/actor', $payload, $headers)
            ->assertStatus(201);
        $this->json('DELETE', '/api/movie/' . $movie->id . '/actor/' . $actor->id, [], $headers)
            ->assertStatus(204);
    }

    /**
     * Test deleting all actors from a movie.
     *
     * @return void
     */
    public function testDeleteAllActorMovie()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $actor = factory(Actor::class)->create();
        $actor2 = factory(Actor::class)->create();

        $movie = factory(Movie::class)->create();

        $payload = [
            'actor_id' => $actor->id,
            'character_name' => 'test'
        ];

        $payload2 = [
            'actor_id' => $actor2->id,
            'character_name' => 'test2'
        ];

        // Add actor to delete.
        $this->json('POST', '/api/movie/' . $movie->id . '/actor', $payload, $headers)
            ->assertStatus(201);
        $this->json('POST', '/api/movie/' . $movie->id . '/actor', $payload2, $headers)
            ->assertStatus(201);
        $this->json('DELETE', '/api/movie/' . $movie->id . '/actor/' . $actor->id, [], $headers)
            ->assertStatus(204);
    }
}
