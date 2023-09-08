<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id'   => rand(1, 500),
            'status'      => rand(0, 1) ? 'active' : 'inactive',
            'name'        => fake()->sentence(4),
            'description' => fake()->text(1000),
            'image'       => 'path/to/image.jpg',
        ];
    }
}
