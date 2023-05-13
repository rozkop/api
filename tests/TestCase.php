<?php

namespace Tests;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
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

    public function createPost($args=[])
    {
       return Post::factory()
        ->create($args);
    }

    public function createComment($args=[])
    {
       return Comment::factory()
        ->create($args);
    }

    public function authUser()
    {
        $user = $this->createUser();
        Sanctum::actingAs($user);
        return $user;
    }
}
