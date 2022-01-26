<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class ParkingLotTile extends Model
{
    use HasFactory, Uuids;
    protected $guarded = ["id"];

    public function parking_details(){
        $this->belongsTo(ParkingLotDetail::class);
    }

    public function slot_details(){
        $this->hasMany(ParkingSlotDetails::class);
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($tile) { // before delete() method call this
             $tile->slot_details()->delete();
             // do the rest of the cleanup...
        });
    }
}
