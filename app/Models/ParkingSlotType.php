<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlotTypes extends Model
{
    use HasFactory;
    protected $fillables = ["type", "rate"];
}
