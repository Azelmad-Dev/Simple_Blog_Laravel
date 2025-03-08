<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * The seeder should not dispatch model events.
     * for example when we have event listener that =>
     *  => sends a welcome email whenever a new user is created, WithoutModelEvents trait will prevent this.
     */
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        // Create 2 users
        $users = User::factory(4)->create();

        // Create 2 categories
        $categories = Category::factory(4)->create();

        // NOTE: The recycle() method overrides the factory definitions
        // that would normally create new users and categories.
        //
        // EXAMPLE:
        // In PostFactory we have:
        //   'user_id' => User::factory(), // Would normally create a NEW user
        //   'category_id' => Category::factory(), // Would normally create a NEW category
        //
        // Without recycle():
        //   Post::factory(2)->create();
        //   // Result: 2 posts + 2 new users + 2 new categories = 6 total models
        //
        // With recycle():
        //   Post::factory(2)->recycle($users)->recycle($categories)->create();
        //   // Result: 2 posts + 0 new users + 0 new categories = 2 total models
        //   // (reusing existing users and categories from the collections)

        // version 1
        Post::factory(8)
            // pick a user randomly from the $users collection we already created.
            ->recycle($users)
            // pick a category randomly from the $categories collection we already created.
            ->recycle($categories)
            // creates 2 comments for each post. The recycle($users) part tells it to use our
            // existing users for the comments rather than creating new ones.
            ->has(Comment::factory(2)->recycle($users))
            ->create();

        // version 2
        // Post::factory(2)
        //     // pick a user randomly from the $users collection we already created.
        //     ->recycle($users)
        //     // pick a category randomly from the $categories collection we already created.
        //     ->recycle($categories)
        //     // creates 2 comments for each post. The recycle($users) part tells it to use our
        //     // existing users for the comments rather than creating new ones.
        //     ->has(Comment::factory(2)
        //         ->state(function (array $attributes, Post $post) {
        //             return ['content' => 'this comment if for ' . $post->title];
        //         })
        //         ->recycle($users))
        //     ->create();
    }
}
