<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private Model $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
    }

    public function login($credentials): TestResponse
    {
        return $this->postJson(route('account.login'), $credentials);
    }

    public function test_successful_login_with_correct_credentials(): void
    {
        $response = $this->login([
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'token',
                ],
            ]);
    }

    public function test_failed_login_with_invalid_credentials(): void
    {
        $response = $this->login([
            'email' => 'test@example.com',
            'password' => 'wrongPassword',
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure(['message']);
    }
}
