<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
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
            'title' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'image' => 'default-image.jpg',
            // By setting 'user_id' => User::factory() in a definition, Laravel will automatically create a new User whenever you create a Post
            // but notice that recycle() method overrides creating a new User
            'user_id' => User::factory(),
            // By setting 'category_id' => Category::factory() in a definition, Laravel will automatically create a new Category whenever you create a Post
            // but notice that recycle() method overrides creating a new Category
            'category_id' => Category::factory(),
        ];
    }
}
