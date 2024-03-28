<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seo>
 */
class SeoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'meta_title' => $this->faker->sentence,
            'meta_description' => $this->faker->sentence,
            'schema' => $this->faker->sentence,
            'meta_keywords' => $this->faker->sentence,
            'cannonical_url' => $this->faker->sentence,
            'og_title' => $this->faker->title(),
            'og_description' => $this->faker->text(),
            'og_image' => $this->faker->imageUrl(),
            'category_id'=>Category::all()->random()->id,
            'post_id'=>Post::all()->random()->id,
            'tag_id'=>Tag::all()->random()->id

        ];
    }
}
