<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingLotEntrancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_lot_entrances', function (Blueprint $table) {
            // $table->uuid('id')->primary();
            $table->id();
            $table->unsignedBigInteger("parking_lot_tile_id");
            $table->string('name', 10);
            $table->foreign("parking_lot_tile_id","ple_plt_id")->references("id")->on("parking_lot_tiles");
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
        Schema::dropIfExists('parking_lot_entrances');
    }
}
