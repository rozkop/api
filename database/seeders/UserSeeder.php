<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->has(
                Community::factory(1)
                    ->has(
                        Post::factory(rand(1, 5))
                            ->has(Comment::factory(rand(3, 7)))
                    )
            )
            ->create();

        User::factory()->create([
            'name' => 'AdminUser',
            'email' => 'admin@example.com',
        ])->assignRole('admin');

    }
}
