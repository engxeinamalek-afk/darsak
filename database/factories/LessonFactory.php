<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lesson>
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
        $videoPlatform = $this->faker->randomElement(['youtube', 'vimeo']);
        $videoUrl = $videoPlatform === 'youtube' 
            ? 'https://youtube.com' . $this->faker->regexify('[A-Za-z0-9_-]{11}')
            : 'https://vimeo.com' . $this->faker->randomNumber(9, true);

        return [
            'name' => $this->faker->sentence(2), 
            'course_id' => Course::inRandomOrder()->first()?->id ?? Course::factory(),
            'url' => $videoUrl,
            'created_at' => $this->faker->dateTimeBetween('-5 months', 'now'),
            'updated_at' => fn (array $attributes) => $attributes['created_at'],
        ];
    }

}
