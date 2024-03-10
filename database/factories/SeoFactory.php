<?php

namespace Database\Factories;

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
            'seo_type'=>fake()->randomElement(['post','category','tag']),
            'parent_id'=>fake()->randomElement([1,2,3,4,5,6,7,8,9]),
        ];
    }
}
