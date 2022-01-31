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
            $table->unsignedBigInteger("parking_slot_detail_id");
            $table->unsignedBigInteger("parking_lot_entrance_id");
            $table->integer('distance')->default(0);
            $table->foreign("parking_slot_detail_id","psd_psd_id")->references("id")->on("parking_slot_details");
            $table->foreign("parking_lot_entrance_id","psd_ple_id")->references("id")->on("parking_lot_entrances");
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
