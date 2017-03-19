<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_classrooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('教室名');
            $table->unsignedInteger('building_id')->comment('教学楼名');
            $table->foreign('building_id')->references('id')->on('list_buildings');
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
        Schema::dropIfExists('list_classrooms');
    }
}
