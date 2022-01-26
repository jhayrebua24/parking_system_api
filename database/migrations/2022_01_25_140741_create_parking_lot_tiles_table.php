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
            $table->uuid('id')->primary();
            $table->uuid("parking_lot_detail_id");
            $table->json("entrance_distance")->nullable();
            $table->boolean("is_obstacle")->default(0);
            $table->boolean("is_open_space")->default(1);
            $table->boolean("is_parking_space")->default(0);
            $table->foreign("parking_lot_detail_id","pld_id")->references("id")->on("parking_lot_details");
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
