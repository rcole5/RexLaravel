<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    public function testLogoutSuccessfully()
    {
        // Create user for authentication.
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Check user is logged in first.
        $this->json('GET', '/api/actor', [], $headers)->assertStatus(200);

        // Check user is logged out.
        $this->json('POST', '/api/logout', [], $headers)->assertStatus(200);

        // Check API key is empty.
        $user = User::find($user->id);
        $this->assertEquals(null, $user->api_key);
    }
}
