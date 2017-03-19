<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_districts', function (Blueprint $table) {
            $table->increments('id');
    	    $table->string('name');
    	    $table->unsignedInteger('city_id');
    	    $table->foreign('city_id')->references('id')->on('list_cities');
    	    $table->unique(['city_id','name']);
    	    $table->index('city_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_districts');
    }
}
