<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3), 
            'body' => $this->faker->paragraph(2), 
            'lesson_id' => Lesson::factory(), 
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => fn (array $attributes) => $attributes['created_at'],
        ];
    }
}
