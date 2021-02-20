<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected $defaultHeaders = [
        'accept' => 'application/json'
    ];

    protected function setUp(): void
    {
        parent::setUp();

        // Clean modpacks folders
        $directories = Storage::disk('modpacks')->allDirectories();
        foreach ($directories as $directory) {
            Storage::disk('modpacks')->deleteDirectory($directory);
        }
    }

    public function initUser($role = 'default', array $props = []): User
    {
        $user = User::factory()->create(array_merge([
            'role' => $role,
        ], $props));

        Sanctum::actingAs($user);

        return $user;
    }

}
