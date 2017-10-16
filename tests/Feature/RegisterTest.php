<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    public function testRegistration()
    {
        $payload = [
          'name' => 'Ryan',
          'email' => 'test@test.com',
          'password' => 'Kappa123',
          'password_confirmation' => 'Kappa123'
        ];

        $this->json('POST', '/api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);
    }

    public function testPasswordMissmatch()
    {
        $payload = [
            'name' => 'Ryan',
            'email' => 'test@test.com',
            'password' => 'Kappa123',
        ];

        $this->json('POST', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'password' => ['The password confirmation does not match.'],
                ],
            ]);
    }

    public function testMissingData()
    {
        $this->json('POST', '/api/register')
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }
}
