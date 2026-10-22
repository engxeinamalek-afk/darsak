<?php

namespace Database\Factories;

use App\Enums\CommentableType;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $studentId = User::where('role', 'student')->inRandomOrder()->first()?->id ?? User::factory()->student();

        $enumCase = $this->faker->randomElement(CommentableType::cases());

        $commentableId = match ($enumCase->value) {
            'course' => Course::inRandomOrder()->first()?->id ?? Course::factory(),
            'lesson' => Lesson::inRandomOrder()->first()?->id ?? Lesson::factory(),
            'task'   => Task::inRandomOrder()->first()?->id ?? Task::factory(),
        };
        return [
            'body'             => $this->faker->paragraph(2),
            'student_id'       => $studentId,
            'commentable_type' => $enumCase, 
            'commentable_id'   => $commentableId,
            'created_at'       => $this->faker->dateTimeBetween('-4 months', 'now'),
            'updated_at'       => fn (array $attributes) => $attributes['created_at'],
        ];
    }
}
