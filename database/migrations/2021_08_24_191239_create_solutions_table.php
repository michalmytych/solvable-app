<?php

use App\Enums\SolutionStatusType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solutions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreignUuid('problem_id')
                ->references('id')
                ->on('problems')
                ->onDelete('cascade');
            $table->foreignUuid('code_language_id')
                ->references('id')
                ->on('code_languages')
                ->onDelete('cascade');
            $table->longText('code')
                ->nullable();
            $table->smallInteger('score')
                ->unsigned()
                ->nullable();
            $table->smallInteger('execution_time')
                ->unsigned()
                ->nullable();
            $table->smallInteger('memory_used')
                ->unsigned()
                ->nullable();
            $table->smallInteger('characters')
                ->unsigned()
                ->nullable();
            $table->unsignedSmallInteger('status')
                ->default(SolutionStatusType::EMPTY);
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
        Schema::dropIfExists('solutions');
    }
}
