<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Author;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Content;
use App\Models\FlashNew;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\Seo;
use App\Models\SpecialSection;
use App\Models\Tag;
use App\Models\TagPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(2)->create();
        Author::factory(2)->create();
        // Category::factory(6)->create();
        Tag::factory(15)->create();
        Post::factory(100)->create();
        Content::factory(1000)->create();
        SpecialSection::factory(100)->create();
        TagPost::factory(100)->create();
        Seo::factory(100)->create();
        Comment::factory(1000)->create();
        FlashNew::factory(3)->create();
                User::first()->update([
                    'email' => 'admin@gmail.com',
                    'password' => Hash::make('12345678'),
                ]);
                Author::first()->update([
                    'user_id' => User::first()->id
                ]);
                Post::first()->update([
                    'author_id' => Author::first()->id
                ]);
                $category = Category::factory()
                    ->hasAttached(
                        Post::factory()->count(2)
                    )
                    ->make();
                $post = Post::factory()
                    ->hasAttached(
                        Category::factory()->count(3)
                    )
                    ->make();
    }
}
