<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodeLanguageProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_language_problem', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('problem_id')
                ->references('id')
                ->on('problems');
            $table->foreignUuid('code_language_id')
                ->references('id')
                ->on('code_languages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('code_language_problem');
    }
}
