<?php

namespace Tests\Feature;


use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_it_login_user()
    {
        $response = $this->post('api/login',
        [
            'email' => 'tester@example.com',
            'password' => 'password',
        ]);
        $response->assertStatus(200);
    }
}
