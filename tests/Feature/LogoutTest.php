<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function test_logout()
    {
        $user = User::create([
            'name' => 'vladislav',
            'email' => 'vlad@gmail.com',
            'password' => bcrypt('secret'),
        ]);

        $token = $user->createToken('iphone')->plainTextToken;

        $response = $this->post('/api/logout', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertSuccessful();
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
