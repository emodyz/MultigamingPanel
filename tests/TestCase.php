<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $defaultHeaders = [
        'accept' => 'application/json'
    ];

    public function initUser(): User {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        return $user;
    }

}
