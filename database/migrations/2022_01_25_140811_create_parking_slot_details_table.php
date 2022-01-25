<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingSlotDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_slot_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("parking_lot_tiles_id")->unsigned();
            $table->bigInteger("parking_slot_types_id")->unsigned();
            $table->foreign("parking_lot_tiles_id","plt_id")->references("id")->on("parking_lot_tiles");
            $table->foreign("parking_slot_types_id","pst_id")->references("id")->on("parking_slot_types");
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
        Schema::dropIfExists('parking_slot_details');
    }
}
