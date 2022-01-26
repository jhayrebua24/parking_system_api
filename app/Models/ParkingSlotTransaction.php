<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class ParkingSlotTransaction extends Model
{
    use HasFactory, Uuids;
    protected $guarded = ["id"];

    public function slot_details(){
        $this->belongsTo(ParkingSlotDetail::class);
    }
}
