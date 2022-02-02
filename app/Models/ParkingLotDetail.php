<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingLotDetail extends Model
{
    use HasFactory;
    protected $fillable = ["height", "width", "name"];

    public function tiles(){
        return $this->hasMany(ParkingLotTile::class);
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($tile) { // before delete() method call this
            $delete_tile = false;
            $tile->tiles->each(function ($tile, $key) {
                $slot_details = $tile->slot_details;
                if($slot_details) {
                    $slot_details->transactions()->delete();
                    $slot_details->entrance_distance()->delete();
                    $slot_details->delete();
                }
                $tile->entrance_details()->delete();
            });
            $tile->tiles()->delete();
        });
    }
}
