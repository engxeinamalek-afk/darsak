<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
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
            'name' => $this->faker->sentence(2),
            'instructor_id' => User::where('role', 'instructor')->inRandomOrder()->first()?->id ?? User::factory()->instructor(),
            'status' => $this->faker->randomElement(['draft', 'published']),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => fn (array $attributes) => $attributes['created_at'],
        ];
    }
}
