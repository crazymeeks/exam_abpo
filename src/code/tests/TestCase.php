<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        User::factory()->create();
    }

    protected function authenticate()
    {
        $response = $this->json('POST', route('api.login'), [
            'email' => 'user1@example.com',
            'password' => 'password'
        ]);

        $headers = [
            'Authorization' => sprintf("Bearer %s", $response->original['token'])
        ];

        return $headers;

    }
}
