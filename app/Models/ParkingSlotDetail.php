<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlotDetail extends Model
{
    use HasFactory;
    protected $fillables = ["parking_lot_tiles_id", "parking_slot_types_id"];
}
