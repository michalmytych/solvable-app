<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Problem;
use Illuminate\Database\Seeder;

class GroupProblemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Problem::first()
            ->groups()
            ->sync([Group::first()->id]);
    }
}
