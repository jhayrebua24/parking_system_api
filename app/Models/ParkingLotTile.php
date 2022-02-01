<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingLotTile extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function parking_details(){
        return $this->belongsTo(ParkingLotDetail::class);
    }

    public function slot_details(){
        return $this->hasOne(ParkingSlotDetail::class);
    }

    public function entrance_details(){
        return $this->hasOne(ParkingLotEntrance::class);
    }
}
