<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text'=>$this->faker->text(20),
            'user_id'=>User::factory(),
            'post_id'=>Post::factory(),
            'upvotes'=> $this->faker->numberBetween(10, 150),
            'downvotes'=> $this->faker->numberBetween(10, 150),
            'rating' => Comment::ratingUpdate(),
        ];
    }
}
