<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::all();
        $faker = Faker::create();

        Lesson::factory()
            ->count(50)
            ->has(Task::factory())
            ->create()
            ->each(function ($lesson) use ($tags, $faker) {
                if ($tags->isNotEmpty()) {
                    
                    if ($faker->boolean(20)) {
                        $lesson->tags()->attach($tags->random(1)->pluck('id')->toArray());
                    }

                    if ($lesson->task && $faker->boolean(20)) {
                        $lesson->task->tags()->attach($tags->random(1)->pluck('id')->toArray());
                    }
                }
            });
    }
}
