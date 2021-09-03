<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('executions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('solution_id')
                ->references('id')
                ->on('solutions')
                ->onDelete('cascade');
            $table->foreignUuid('test_id')
                ->references('id')
                ->on('tests')
                ->onDelete('cascade');
            $table->unsignedInteger('execution_time')
                ->nullable();
            $table->unsignedInteger('memory_used')
                ->nullable();
            $table->string(
                'output',
                config('services.external-compiler-client.max-chars-in-external-compiler-output')
            )
                ->nullable();
            $table->boolean('passed')->default(false);
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
        Schema::dropIfExists('executions');
    }
}
