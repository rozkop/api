<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(20)->create();
        Post::factory(50)->create();


         User::factory()->create([
             'name' => 'TestUser',
             'email' => 'test@example.com',
         ]);
    }
}
