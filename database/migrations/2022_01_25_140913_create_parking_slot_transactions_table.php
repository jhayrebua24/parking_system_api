<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingSlotTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_slot_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("parking_slot_details_id")->unsigned();
            $table->foreign("parking_slot_details_id","psd_id")->references("id")->on("parking_slot_details");
            $table->string("plate_number",6);
            $table->datetime("datetime_in");
            $table->datetime("datetime_out")->nullable();
            $table->integer("total_hrs")->nullable();
            $table->float("total_amount")->nullable();
            $table->boolean("is_continuous")->default(0);
            $table->integer("continuous_trans_id")->nullable();
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
        Schema::dropIfExists('parking_slot_transactions');
    }
}
