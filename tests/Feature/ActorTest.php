<?php

namespace Tests\Feature;

use \App\Models\Actor;
use App\User;
use Tests\TestCase;

class ActorTest extends TestCase
{
    /**
     * Tests if actor list is returned.
     *
     * @return void
     */
    public function testGetActor()
    {
        // Creates user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('get', '/api/actor', [], $headers)
            ->assertStatus(200);
    }

    /**
     * Test if actor is created successfully.
     *
     * @return void
     */
    public function testCreateActor()
    {
        // Creates user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'name' => 'Test',
            'dob' => '1990-03-03',
            'bio' => 'this is a test bio.',
        ];

        $this->json('post', '/api/actor', $payload, $headers)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'Test',
                    'dob' => '1990-03-03',
                    'bio' => 'this is a test bio.',
                ],
            ]);
    }

    /**
     * Test if actor was updated.
     *
     * @return void
     */
    public function testUpdateActor()
    {
        // Create user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Create actor.
        $actor = factory(Actor::class)->create();

        // Set payload for updating.
        $payload = [
            'name' => 'New Name'
        ];

        // Test the update.
        $this->json('PUT', '/api/actor/' . $actor->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'New Name'
                ],
            ]);

    }

    /**
     * Tests if actor was deleted.
     *
     * @return void
     */
    public function testDeleteActor()
    {
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Create actor.
        $actor = factory(Actor::class)->create();
        $actorId = $actor->id;
        // Test deleting actor.
        $this->json('DELETE', '/api/actor/' . $actor->id, [], $headers)
            ->assertStatus(204);

        // Tests actor was deleted.
        $this->assertEquals(null, Actor::find($actorId));
    }

    /**
     * Tests getting a single actor.
     *
     * @return void
     */
    public function testShowActor()
    {
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Create actor.
        $actor = factory(Actor::class)->create([
            'name' => 'Test Show'
        ]);

        $this->json('GET', '/api/actor/' . $actor->id, [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Test Show'
                ]
            ]);
    }
}
