<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlotDistance extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function tile(){
        return $this->belongsTo(ParkingLotTile::class);
    }

    public function entrance(){
        return $this->belongsTo(ParkingLotEntrance::class);
    }
}
