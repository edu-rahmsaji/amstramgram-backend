<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
        $imagesPaths = ['storage/posts/screen_1.png', 'storage/posts/screen_2.png', 'storage/posts/screen_3.png', 'storage/posts/screen_4.png', 'storage/posts/screen_5.png'];
        $count = fake()->numberBetween(0, 5);

        $randomIndices = [];
        for ($i = 0; $i < $count; $i++) {
            $randomIndices[] = array_rand($imagesPaths);
        }

        $randomImagePaths = array_values(Arr::only($imagesPaths, $randomIndices));

        return [
            'user_id' => fake()->numberBetween(1, 10),
            'text' => fake()->text(),
            'image_paths' => json_encode($randomImagePaths)
        ];
    }
}
