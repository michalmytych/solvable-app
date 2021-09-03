<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CodeLanguageSeeder::class,
            ProblemSeeder::class,
            SolutionSeeder::class,
            TestSeeder::class,
            CodeLanguageProblemTableSeeder::class,
            CourseSeeder::class,
            GroupSeeder::class,
            GroupCourseTableSeeder::class,
            GroupProblemTableSeeder::class
        ]);
    }
}
