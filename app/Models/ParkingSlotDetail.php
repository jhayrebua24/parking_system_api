<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class ParkingSlotDetail extends Model
{
    use HasFactory, Uuids;
    protected $fillable = ["parking_lot_tiles_id", "parking_slot_types_id"];

    public function tile(){
        $this->belongsTo(ParkingLotTile::class);
    }

    public function type(){
        $this->belongsTo(ParkingSlotType::class);
    }

    public function transactions(){
        $this->hasMany(ParkingSlotTransaction::class);
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($detail) { // before delete() method call this
             $detail->transactions()->delete();
             // do the rest of the cleanup...
        });
    }
}
