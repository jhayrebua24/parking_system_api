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
            // $table->uuid('id')->primary();
            $table->id();
            $table->unsignedBigInteger("parking_lot_tile_id");
            $table->unsignedBigInteger("parking_slot_type_id");
            $table->boolean("is_occupied")->default(0);
            // $table->foreign("parking_lot_tile_id","plt_id")->references("id")->on("parking_lot_tiles");
            // $table->foreign("parking_slot_type_id","pst_id")->references("id")->on("parking_slot_types");
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
