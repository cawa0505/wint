<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_grades', function (Blueprint $table) {
            //成绩表，包括课程id，用户id，所属年份，所属学期，成绩，类型（补考，重修，免修），评分教师，所占学分
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('user_id');
            $table->string('year');
            $table->string('term');
            $table->float('grade');
            $table->unsignedTinyInteger('state')->default(0)->comment('类型,0正常,1补考,2重修,3免修');
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('credit')->comment('所占学分');
            $table->foreign('course_id')->references('id')->on('edu_courses');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('teacher_id')->references('id')->on('edu_teachers');
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
        Schema::dropIfExists('edu_grades');
    }
}
