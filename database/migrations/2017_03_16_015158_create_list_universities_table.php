<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_universities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('district_id');
            $table->double('longitude')->comment('学校精度，用于地理位置获取学校');
            $table->double('latitude')->comment('维度，同上');
            $table->foreign('district_id')->references('id')->on('list_districts');
            $table->index('district_id');
            $table->unique(['name','district_id']);
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
        Schema::dropIfExists('list_universities');
    }
}
