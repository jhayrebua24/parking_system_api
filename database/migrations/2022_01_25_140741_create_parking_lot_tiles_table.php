<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingLotTilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_lot_tiles', function (Blueprint $table) {
            $table->id();
            $table->json("entrance_distance")->nullable();
            $table->boolean("is_obstacle")->default(0);
            $table->boolean("is_open_space")->default(1);
            $table->boolean("is_parking_space")->default(0);
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
        Schema::dropIfExists('parking_lot_tiles');
    }
}
