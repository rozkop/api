<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use App\Models\Community;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(15),
            'text' => $this->faker->sentence(50),
            'user_id' => User::factory(),
            'upvotes'=> $this->faker->numberBetween(10, 150),
            'downvotes'=> $this->faker->numberBetween(10, 150),
            'community_id' => Community::factory(),
            'rating' => Post::ratingUpdate(),
        ];
    }
}
