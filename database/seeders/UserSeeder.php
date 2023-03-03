<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create();

        if (App::hasDebugModeEnabled()) {
            User::factory()->firstOrCreate([
                'name'  => 'Solvable Developer',
                'email' => 'developer@solvable.com',
            ]);
        }
    }
}
