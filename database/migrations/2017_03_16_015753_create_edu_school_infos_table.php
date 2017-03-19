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
            $table->unsignedInteger('school_id');
            $table->string('website')->comment('学校官方网址');
            $table->string('function_list')->comment('可供查询的功能，json数据');
            $table->string('function_content')->comment('可供查询的功能的访问url,访问方式,正则表达式，解析结果排序。JSON数组套数组');
            $table->unsignedInteger('year')->comment('当前年份');
            $table->string('term',2)->comment('学期，A秋季学期，S春季学期');
            $table->date('new_term')->comment('开学日期，通过其与当前时间比对计算当前周数');
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
