<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(), 
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => fn (array $attributes) => $attributes['created_at'],
        ];
    }
}
