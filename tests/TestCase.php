<?php

namespace Tests;

use App\Models\Community;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function createUser()
    {
        return User::factory()->create();
    }
    public function createCommunity($args=[])
    {
       return Community::factory()
        ->create($args);
    }
    public function authUser()
    {
        $user = $this->createUser();
        Sanctum::actingAs($user);
        return $user;
    }
}
