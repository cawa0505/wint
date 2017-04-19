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
            $table->unsignedInteger('college_id')->comment('所属学院')->nullable();
            $table->unsignedInteger('university_id')->comment('所属学校');
            $table->foreign('college_id')->references('id')->on('list_colleges');
            $table->foreign('university_id')->references('id')->on('list_universities');
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
