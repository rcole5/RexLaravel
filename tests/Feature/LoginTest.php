<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422);
    }

    public function testUserLogInSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'test@test.com',
            'password' => bcrypt('testpassword'),
        ]);

        $payload = ['email' => 'test@test.com', 'password' => 'testpassword'];
        $this->json('POST', '/api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'api_token',
                ],
            ]);
    }
}
