<?php

namespace Database\Factories;

use App\Enums\TaggableType;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Model;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class TaggableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tagId = Tag::inRandomOrder()->first()?->id ?? Tag::factory();

        $enumCase = $this->faker->randomElement(TaggableType::cases());

        $taggableId = match ($enumCase->value) {
            'course' => Course::inRandomOrder()->first()?->id ?? Course::factory(),
            'lesson' => Lesson::inRandomOrder()->first()?->id ?? Lesson::factory(),
            'task'   => Task::inRandomOrder()->first()?->id ?? Task::factory(),
        };
        return [
            'tag_id'        => $tagId,
            'taggable_type' => $enumCase,
            'taggable_id'   => $taggableId,
        ];
    }
}
