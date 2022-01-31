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

    public static function boot() {
        parent::boot();
        static::deleting(function($tile) { // before delete() method call this
             $tile->slot_details()->delete();
             $tile->entrance_details()->delete();
             // do the rest of the cleanup...
        });
    }
}
