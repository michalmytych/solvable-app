<?php

namespace Database\Seeders;

use App\Models\CodeLanguage;
use Illuminate\Database\Seeder;

class CodeLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CodeLanguage::firstOrCreate([
            'name' => 'C++ 17',
            'identifier' => 'cpp17',
            'version' => 0
        ]);

        CodeLanguage::firstOrCreate([
            'name' => 'C#',
            'identifier' => 'cs',
            'version' => 0
        ]);

        CodeLanguage::firstOrCreate([
            'name' => 'Php 8.0',
            'identifier' => 'php8',
            'version' => 0
        ]);
    }
}
