<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduUserBasicInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_user_basic_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('student_id')->comment('学号');
            $table->string('real_name')->comment('真实姓名')->nullable();
            $table->tinyInteger('sex')->comment('性别，0男1女')->nullable();
            $table->string('photo_url')->comment('皂片')->nullable();
            $table->unsignedInteger('type')->comment('0学生，1老师，还没确定要有啥区别为好')->default(0);
            $table->unsignedInteger('class_id')->comment('班级')->nullable();
            $table->unsignedInteger('year')->comment('入学年份')->nullable();
            $table->string('term',2)->comment('入学学期')->nullable();
            $table->string('user_auth_info')->comment('用户授权信息，json数组')->nullable();
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
        Schema::dropIfExists('edu_user_basic_infos');
    }
}
