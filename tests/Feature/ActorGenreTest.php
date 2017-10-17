<?php

namespace Tests\Feature;

use App\Models\Actor;
use App\Models\Genre;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ActorGenreTest
 * @package Tests\Feature
 */
class ActorGenreTest extends TestCase
{
    /**
     * Test adding genre to an actor.
     *
     * @return void
     */
    public function testAddGenreToActor()
    {
        $actor = factory(Actor::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'sci-fi']);

        $actor->genres()->attach($genre->id);

        $this->assertTrue('sci-fi' == $actor->genres[0]->name);
    }

    /**
     * Test get all actor genres.
     *
     * @return void
     */
    public function testGetActorGenres()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $movie = factory(Actor::class)->create();

        $this->json('GET', '/api/actor/' . $movie->id . '/genre', [], $headers)
            ->assertStatus(200);
    }

    /**
     * Test adding genre to actor.
     *
     * @return void
     */
    public function testAddActorGenre()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $actor = factory(Actor::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'action']);

        $this->json('POST', '/api/actor/' . $actor->id . '/genre/' . $genre->id, [], $headers)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'genres' => [
                        'action'
                    ],
                ],
            ]);
    }

    public function testAddMultipleActorGenre()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $actor = factory(Actor::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'action']);
        $genre2 = factory(Genre::class)->create(['name' => 'sci-fi']);

        $this->json('POST', '/api/actor/' . $actor->id . '/genre/' . $genre->id, [], $headers)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'genres' => [
                        'action'
                    ],
                ],
            ]);

        $this->json('POST', '/api/actor/' . $actor->id . '/genre/' . $genre2->id, [], $headers)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'genres' => [
                        'action',
                        'sci-fi'
                    ],
                ],
            ]);
    }

    /**
     * Test deleting genres from actor.
     *
     * @return void
     */
    public function testDeleteMovieGenre()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $actor = factory(Actor::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'action']);

        // Add genre to delete.
        $this->json('POST', '/api/actor/' . $actor->id . '/genre/' . $genre->id, [], $headers)
            ->assertStatus(201);

        // Delete the genre.
        $this->json('DELETE', '/api/actor/' . $actor->id . '/genre/' . $genre->id, [], $headers)
            ->assertStatus(204);
    }

    /**
     * Test deleting all genres from actor.
     *
     * @return void
     */
    public function testDeleteAllActorGenres()
    {
        $user = factory(User::class)->create();

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $actor = factory(Actor::class)->create();
        $genre = factory(Genre::class)->create(['name' => 'action']);
        $genre2 = factory(Genre::class)->create(['name' => 'sci-fi']);


        // Add genre to delete.
        $this->json('POST', '/api/actor/' . $actor->id . '/genre/' . $genre->id, [], $headers)
            ->assertStatus(201);

        $this->json('POST', '/api/actor/' . $actor->id . '/genre/' . $genre2->id, [], $headers)
            ->assertStatus(201);

        // Delete the genre.
        $this->json('DELETE', '/api/actor/' . $actor->id . '/genre/' . $genre->id, [], $headers)
            ->assertStatus(204);
    }
}
