<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Course;
use Illuminate\Database\Seeder;

class GroupCourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::first()
            ->courses()
            ->attach(Course::first()->id);
    }
}
