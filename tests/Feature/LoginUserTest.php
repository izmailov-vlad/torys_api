<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = User::create([
            'name' => 'vladislav',
            'email' => 'vlad@gmail.com',
            'password' => bcrypt('secret'),
        ]);

        $response = $this->post("/api/login", [
            "email" => $user->email,
            "password" => "secret",
            "device_name" => "iphone",
        ]);

        $response->assertSuccessful();
        $this->assertNotEmpty($response->getContent());
        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'iphone',
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id
        ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_user_from_token()
    {
        $user = User::create([
            'name' => 'vladislav',
            'email' => 'vlad@gmail.com',
            'password' => bcrypt('secret'),
        ]);

        $token = $user->createToken('iphone')->plainTextToken;

        $response = $this->get('/api/user', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertSuccessful();
        $response->assertJson(function ($json) {
            $json->where('email', 'vlad@gmail.com')
                ->missing('password')
                ->etc();
        });
    }


}
