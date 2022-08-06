<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(mt_rand(2,5)),
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->paragraph(),

            // 'body' => '<p>' . implode('</p><p>', $this->faker->paragraphs(mt_rand(5,7))) . '</p>', // implode itu gabungin dengan pemisah </p><p>

            // Cara biar bisa bikin jadi paragraphs
            'body' => collect($this->faker->paragraphs(mt_rand(5,7)))
                        ->map(fn($p) => "<p>$p</p>")->implode(''),
            'user_id' => mt_rand(1,5),
            'category_id' => mt_rand(1,3)
        ];
    }
}
