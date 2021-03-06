<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlotDetail extends Model
{
    use HasFactory;
    protected $fillable = ["parking_lot_tile_id", "parking_slot_type_id"];

    public function tile(){
        return $this->belongsTo(ParkingLotTile::class, 'parking_lot_tile_id');
    }

    public function slot_type(){
        return $this->belongsTo(ParkingSlotType::class, 'parking_slot_type_id');
    }

    public function transactions(){
        return $this->hasMany(ParkingSlotTransaction::class, 'parking_slot_detail_id');
    }

    public function entrance_distance(){
        return $this->hasMany(ParkingSlotDistance::class, 'parking_slot_detail_id');
    }
}
