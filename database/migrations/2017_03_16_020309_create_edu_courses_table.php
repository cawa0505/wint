<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_courses', function (Blueprint $table) {
            //课程一定要唯一，用课程编码区分，
            $table->increments('id');
            $table->string('name')->comment('课程名');
            $table->string('code')->comment('课程编码');
            $table->integer('college_id')->comment('开课学院');
            $table->unsignedTinyInteger('is_common')->comment('1公共 0专业');
            $table->unsignedTinyInteger('is_required')->comment('1必修 0选修');
            $table->foreign('college_id')->references('id')->on('list_colleges');
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
        Schema::dropIfExists('edu_courses');
    }
}
