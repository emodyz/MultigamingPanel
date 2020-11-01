<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    const USER_PASSWORD = 'SuperPassword!1';

    /**
     * @test
     */
    public function user_can_login()
    {
        $user = User::factory()->create([
            'password' => Hash::make(self::USER_PASSWORD)
        ]);

        $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => self::USER_PASSWORD,
            'device_name' => 'UnitTests'
        ])->assertOk()
        ->assertJsonStructure([
            'access_token',
            'user' => [
                'name',
                'email'
            ]
        ]);
    }

    /**
     * @test
     */
    public function login_with_wrong_password_must_fail()
    {
        $user = User::factory()->create([
            'password' => Hash::make(self::USER_PASSWORD)
        ]);

        $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'WrongPassword',
            'device_name' => 'UnitTests'
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
