<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingLotEntrance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function tile() {
        return $this->belongsTo(ParkingLotTile::class, 'parking_lot_tile_id');
    }

    public function distance() {
        return $this->hasMany(ParkingSlotDistance::class,'parking_lot_entrance_id');
    }
}
