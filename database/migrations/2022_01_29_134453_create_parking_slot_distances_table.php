<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingSlotDistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_slot_distances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("parking_lot_tile_id");
            $table->integer('distance')->default(0);
            $table->foreign("parking_lot_tile_id","psd_plt_id")->references("id")->on("parking_lot_tiles");
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
        Schema::dropIfExists('parking_slot_distances');
    }
}
