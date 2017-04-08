<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('sex')->comment('性别');
            $table->unsignedInteger('college_id')->comment('所属学院');
            $table->foreign('college_id')->references('list_colleges')->on('id');
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
        Schema::dropIfExists('edu_teachers');
    }
}
