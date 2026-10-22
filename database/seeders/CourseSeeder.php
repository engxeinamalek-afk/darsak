<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::all();
        $faker = Faker::create();

        Course::factory()->count(15)->create()->each(function ($course) use ($tags, $faker) {
            if ($tags->isNotEmpty() && $faker->boolean(50)) {
                $count = min(rand(1, 2), $tags->count());
                
                $course->tags()->attach(
                    $tags->random($count)->pluck('id')->toArray()
                );
            }
        });
    }
}
