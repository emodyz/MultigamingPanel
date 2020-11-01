<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function forgot_password_request_must_send_mail()
    {
        Notification::fake();
        Notification::assertNothingSent();

        $user = User::factory()->create();

        $this->post('/api/auth/password/forgot', [
            'email' => $user->email
        ])->assertOk();

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
