<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_buildings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('教学楼名');
            $table->unsignedInteger('university_id');
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
        Schema::dropIfExists('list_buildings');
    }
}
