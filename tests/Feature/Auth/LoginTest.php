<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class LoginTest extends TestCase
{
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

    /**
     * @test
     */
    public function if_2FA_is_enabled_i_am_a_teapot_status_must_be_returned_if_no_code_was_provided()
    {
        $user = User::factory()->create([
          'password' => Hash::make(self::USER_PASSWORD),
          'two_factor_secret' => Str::random(10)
        ]);

        $this->post('/api/auth/login', [
          'email' => $user->email,
          'password' => self::USER_PASSWORD,
          'device_name' => 'UnitTests'
        ])->assertStatus(Response::HTTP_I_AM_A_TEAPOT);
    }
}
