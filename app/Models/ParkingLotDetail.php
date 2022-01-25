<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingLotDetail extends Model
{
    use HasFactory;
    protected $fillables = ["height", "width"];
}
