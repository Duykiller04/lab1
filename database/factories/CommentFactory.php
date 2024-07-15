<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        $commentableTypes = ['App\Models\Article', 'App\Models\Image', 'App\Models\Video'];
        return [
            'user_id' => rand(1, 10),
            'content' => fake()->text(),
            'commentable_id' => rand(1, 10),
            'commentable_type' => fake()->randomElement($commentableTypes),
        ];
    }
}
