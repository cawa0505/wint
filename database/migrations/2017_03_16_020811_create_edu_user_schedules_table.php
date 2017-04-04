<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduUserSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_user_schedules', function (Blueprint $table) {
            //用户与课程对应表
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('schedule_id')->comment('课程排表id');
            $table->string('year',4);
            $table->string('term',2);
            $table->string('remark')->comment('备注');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('schedule_id')->references('id')->on('edu_schedules');
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
        Schema::dropIfExists('edu_user_schedules');
    }
}
