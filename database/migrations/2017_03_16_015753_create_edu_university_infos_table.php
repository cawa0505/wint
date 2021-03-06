<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduUniversityInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edu_university_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('university_id');
            $table->string('website')->comment('学校官方网址');
            $table->text('function_list')->comment('可供查询的功能，json数据');
            $table->text('function_content')->comment('可供查询的功能的访问url,访问方式,正则表达式，解析结果排序。JSON数组套数组');
            $table->date('new_term')->comment('最新一次开学日期，通过其与当前时间比对计算当前周数');
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
        Schema::dropIfExists('edu_university_infos');
    }
}
