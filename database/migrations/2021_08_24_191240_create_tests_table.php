<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('problem_id')
                ->references('id')
                ->on('problems')
                ->onDelete('cascade');
            $table->foreignUuid('solution_id')
                ->references('id')
                ->on('solutions');
            $table->string('input');
            $table->json('valid_outputs');
            $table->decimal('time_limit');
            $table->unsignedSmallInteger('memory_limit');
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
        Schema::dropIfExists('tests');
    }
}
