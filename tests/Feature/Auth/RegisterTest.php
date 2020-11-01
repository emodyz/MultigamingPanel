<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    const USER_EMAIL = 'foo@bar.com';
    const USER_NAME = 'Foo';
    const USER_PASSWORD = 'SuperPassword1/£';

    /**
     * @test
     */
    public function user_can_register()
    {
        $this->assertCount(0, User::all());

        $this->post('/api/auth/register', [
            'email' => self::USER_EMAIL,
            'name' => self::USER_NAME,
            'password' => self::USER_PASSWORD,
            'password_confirmation' => self::USER_PASSWORD
        ])->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'email',
                'name'
            ]
        ]);

        $this->assertCount(1, User::all());

        $user = User::first();

        $this->assertEquals(self::USER_EMAIL, $user->email);
        $this->assertEquals(self::USER_NAME, $user->name);
    }

    /**
     * @test
     */
    public function registered_user_can_login()
    {
        $this->post('/api/auth/register', [
            'email' => self::USER_EMAIL,
            'name' => self::USER_NAME,
            'password' => self::USER_PASSWORD,
            'password_confirmation' => self::USER_PASSWORD
        ])->assertCreated();

        $this->post('/api/auth/login', [
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
            'device_name' => 'UnitTests'
        ])
            ->assertOk()
            ->assertJson([
                'user' => [
                    'email' => self::USER_EMAIL,
                    'name' => self::USER_NAME
                ]
            ]);
    }
}
