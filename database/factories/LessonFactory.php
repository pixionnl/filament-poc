<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status'      => rand(0, 1) ? 'active' : 'inactive',
            'name'        => fake()->sentence(4),
            'description' => fake()->text(1000),
            'order'       => 1,
        ];
    }
}
