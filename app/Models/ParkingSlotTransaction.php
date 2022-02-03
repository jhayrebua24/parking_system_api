<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlotTransaction extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function slot_details(){
        return $this->belongsTo(ParkingSlotDetail::class, 'parking_slot_detail_id');
    }
}
