<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListProfessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_professions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('college_id')->nullable();
            $table->unsignedInteger('university_id');
            $table->timestamps();
            $table->foreign('college_id')->references('id')->on('list_colleges');
            $table->foreign('university_id')->references('id')->on('list_universities');
            $table->index('college_id');
            $table->unique(['name','college_id']);
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
        Schema::dropIfExists('list_professions');
    }
}
