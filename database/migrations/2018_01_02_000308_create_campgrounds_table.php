<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampgroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campgrounds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contractID');
            $table->string('facilityID');
            $table->string('facilityName');
            $table->string('facilityPhoto');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->text('drivingDirection')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('reservationUrl')->nullable();
            $table->string('sitesWithAmps');
            $table->string('sitesWithPetsAllowed');
            $table->string('sitesWithSewerHookup');
            $table->string('sitesWithWaterHookup');
            $table->string('sitesWithWaterfront');
            $table->json('photos')->nullable();
            $table->json('amenities')->nullable();
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
        Schema::dropIfExists('campgrounds');
    }
}
