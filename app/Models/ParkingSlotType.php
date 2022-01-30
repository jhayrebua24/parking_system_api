<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlotType extends Model
{
    use HasFactory;
    protected $fillable = ["vehicle_size", "rate"];

    public function slot_details() {
        return $this->hasMany(ParkingSlotDetail::class, 'parking_slot_type_id');
    }
}
