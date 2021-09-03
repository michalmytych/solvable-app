<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_problem', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('group_id')
                ->references('id')
                ->on('groups');
            $table->foreignUuid('problem_id')
                ->references('id')
                ->on('problems');
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
        Schema::dropIfExists('group_problem');
    }
}
