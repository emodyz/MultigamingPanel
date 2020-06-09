<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_with_valid_email_and_password_must_receive_access_token()
    {
        $user = factory(User::class)->create();

        $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'unit'
        ])->assertStatus(200)
            ->assertJsonStructure([
                'access_token'
            ]);

    }
}
