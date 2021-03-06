<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlotDistance extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function slot_detail(){
        return $this->belongsTo(ParkingSlotDetail::class, 'parking_slot_detail_id');
    }

    public function entrance(){
        return $this->belongsTo(ParkingLotEntrance::class,'parking_lot_entrance_id');
    }
}
