<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function register(array $credentials): TestResponse
    {
        return $this->postJson(route('account.register'), $credentials);
    }

    public function test_successful_registration_with_correct_credentials(): void
    {
        Notification::fake();

        $response = $this->register([
            'email' => 'randomEmail@example.com',
            'password' => 'passingPassword$1234',
            'password_confirmation' => 'passingPassword$1234',
        ]);

        $response->assertStatus(201)->assertJsonStructure([
            'message',
            'data' => [
                'email',
                'token',
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'randomemail@example.com'
        ]);
    }

    public function test_registration_fails_because_email_already_exists(): void
    {
        User::factory()->create([
            'email' => 'existingEmail@example.com',
            'password' => 'passingPassword$1234',
        ]);

        $response = $this->register([
            'email' => 'existingEmail@example.com',
            'password' => 'passingPassword$1234',
            'password_confirmation' => 'passingPassword$1234',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['email']);
    }

    public function test_registration_fails_because_passwords_do_not_match(): void
    {
        $response = $this->register([
            'email' => 'randomEmail@example.com',
            'password' => 'passingPassword$1234',
            'password_confirmation' => 'anotherPassword$1234',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['password']);
    }

    public function test_registration_fails_because_credentials_are_invalid(): void
    {
        $response = $this->register([
            'email' => 'invalid_email',
            'password' => 'weekPassword',
            'password_confirmation' => 'weekPassword',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['email', 'password']);
    }
}
