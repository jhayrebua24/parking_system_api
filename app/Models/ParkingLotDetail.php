<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class ParkingLotDetail extends Model
{
    use HasFactory, Uuids;
    protected $fillable = ["height", "width", "name"];

    public function tiles(){
        return $this->hasMany(ParkingLotTile::class);
    }
}
