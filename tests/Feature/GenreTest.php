<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GenreTest extends TestCase
{
    public function testGetGenre()
    {
        // Creates user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', '/api/genre', [], $headers)
            ->assertStatus(200);
    }

    public function testCreateGenre()
    {
        // Creates user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'name' => 'action'
        ];

        $this->json('POST', '/api/genre', $payload, $headers)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'action'
                ],
            ]);

    }

    public function testUpdateGenre()
    {
        // Creates user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Create a genre.
        $genre = factory(Genre::class)->create([
            'name' => 'action'
        ]);

        // Create payload to change genre name.
        $payload = [
            'name' => 'sci-fi'
        ];

        // Test updating the genre.
        $this->json('PUT', '/api/genre/' . $genre->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'sci-fi'
                ],
            ]);
    }

    public function testDeleteGenre()
    {
        // Creates user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Create a genre.
        $genre = factory(Genre::class)->create();

        // Test deleting genre.
        $this->json('DELETE', '/api/genre/' . $genre->id, [], $headers)
            ->assertStatus(204);

        // Test genre was deleted.
        $this->assertEquals(null, Genre::find($genre->id));
    }

    public function testShowGenre()
    {
        // Creates user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Create a genre.
        $genre = factory(Genre::class)->create([
            'name' => 'action'
        ]);

        $this->json('GET', '/api/genre/' . $genre->id, [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'action'
                ],
            ]);
    }
}
