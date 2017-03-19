<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
	        $table->unsignedInteger('province_id');
	        $table->foreign('province_id')->references('id')->on('list_provinces');
	        $table->index('province_id');
	        $table->unique(['name','province_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_cities');
    }
}
