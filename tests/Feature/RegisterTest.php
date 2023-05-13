<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_it_store_user()
    {
        $response = $this->post('api/register',
        [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(200);
    }
}
