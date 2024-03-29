<?php

namespace Database\Seeders;

use App\Models\Problem;
use App\Models\CodeLanguage;
use Illuminate\Database\Seeder;

class CodeLanguageProblemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Problem::first()
            ->codeLanguages()
            ->attach(CodeLanguage::first()->id);
    }
}
