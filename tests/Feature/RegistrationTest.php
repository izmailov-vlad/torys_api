<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;
    public function test_registration()
    {
        $response = $this->post('/api/register', [
            'name' => 'vladislav',
            'email' => 'vlad@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSuccessful();
        $this->assertNotEmpty($response->getContent());
        $this->assertDatabaseHas('users', ['email' => 'vlad@gmail.com']);
        $this->assertDatabaseHas('personal_access_tokens', ['name' => 'iphone']);
    }
}
