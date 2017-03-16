<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduSchoolInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_school_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id');
            $table->string('website')->comment('学校官方网址');
            $table->string('function_list')->comment('可供查询的功能，json数据');
            $table->string('function_content')->comment('可供查询的功能的访问url,访问方式,正则表达式，解析结果排序。JSON数组套数组');
            $table->foreign('school_id')->references('id')->on('list_schools');
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
        Schema::dropIfExists('edu_school_infos');
    }
}