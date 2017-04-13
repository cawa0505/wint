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
            $table->date('date')->comment('考试日期');
            $table->time('start_time')->comment('考试开始时间');
            $table->time('end_time')->comment('考试结束时间');
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
