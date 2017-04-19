<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEduUserBasicInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edu_user_basic_infos', function (Blueprint $table) {
            $table->unsignedInteger('university_id');
            $table->foreign('university_id')->references('id')->on('list_universities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('edu_user_basic_infos', function (Blueprint $table) {
            //
        });
    }
}
