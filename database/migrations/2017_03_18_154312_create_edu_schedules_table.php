<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_schedules', function (Blueprint $table) {
            //必须有一个上课时间排表的概念，定义 某节课在什么时间以什么方式上，课堂去对应学生
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('year');
            $table->string('term',2);
            $table->unsignedInteger('start_week')->comment('开始周');
            $table->unsignedInteger('end_week')->comment('结束周');
            $table->unsignedInteger('turning')->comment('0正常，1单周，2双周');
            $table->tinyInteger('day')->comment('周几');
            $table->unsignedInteger('time')->comment('第几节课？');
            $table->unsignedInteger('duration')->comment('上课时长，单位节数');
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('classroom_id')->comment('上课教室id');
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
        Schema::dropIfExists('schedules');
    }
}
