<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campsites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campground_id');
            $table->string('loop');
            $table->integer('maxEquipmentLength');
            $table->integer('maxPeople');
            $table->string('site');
            $table->integer('siteID');
            $table->string('siteType');
            $table->string('amps');
            $table->string('petsAllowed');
            $table->string('sewerHookup');
            $table->string('waterHookup');
            $table->string('waterfront');
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
        Schema::dropIfExists('campsites');
    }
}
