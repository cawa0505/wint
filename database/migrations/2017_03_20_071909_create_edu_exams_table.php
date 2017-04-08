<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_exams', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id')->comment('课程id');
            $table->unsignedInteger('classroom_id')->comment('教室id');
            $table->dateTime('date')->comment('考试时间');
            $table->foreign('course_id')->references('id')->on('edu_courses');
            $table->foreign('classroom_id')->references('id')->on('list_classrooms');
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
        Schema::dropIfExists('edu_exams');
    }
}
