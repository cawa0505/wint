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
            $table->integer('user_id');
            $table->string('user_authinfo')->comment('用户授权信息，json数组，不同网站对应不同信息');
            $table->string('cookies')->comment('用户已登录的session信息，json数组，更新时稍微麻烦一些');
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
