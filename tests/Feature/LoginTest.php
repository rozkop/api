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
        $this->post('api/register',
        [
            'name' => 'Tester2',
            'email' => 'tester2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response = $this->post('api/login',
        [
            'email' => 'tester2@example.com',
            'password' => 'password',
        ]);
        $response->assertStatus(200);
    }
}
