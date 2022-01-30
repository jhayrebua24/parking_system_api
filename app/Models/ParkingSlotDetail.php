<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlotDetail extends Model
{
    use HasFactory;
    protected $fillable = ["parking_lot_tile_id", "parking_slot_type_id"];

    public function tile(){
        return $this->belongsTo(ParkingLotTile::class);
    }

    public function slot_type(){
        return $this->belongsTo(ParkingSlotType::class, 'parking_slot_type_id');
    }

    public function transactions(){
        return $this->hasMany(ParkingSlotTransaction::class);
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($detail) { // before delete() method call this
             $detail->transactions()->delete();
             // do the rest of the cleanup...
        });
    }
}
