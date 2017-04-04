<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_colleges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('university_id');
            $table->timestamps();
            $table->foreign('university_id')->references('id')->on('list_universities');
            $table->index('university_id');
            $table->unique(['name','university_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_colleges');
    }
}
