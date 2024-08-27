<?php

namespace Tests\Feature\Api;


use Tests\TestCase;
use App\Models\User;

class LoginControllerTest extends TestCase
{

    public function test_login()
    {


        $creds = [
            'email' => 'user1@example.com',
        ];

        $response = $this->json('POST', route('api.login'), $creds);
        $response->assertJsonStructure([
            'status',
            'message',
            'token'
        ]);

        $response->assertStatus(200);
    }

    
}
