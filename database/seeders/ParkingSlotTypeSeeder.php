<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingSlotType;
use App\Models\ParkingLotTile;

class ParkingSlotTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ParkingSlotType::insert([
            [
                'vehicle_size' => "Small",
                'rate' => 20,
            ],
            [
                'vehicle_size' => "Medium",
                'rate' => 60,
            ],
            [
                'vehicle_size' => "Large",
                'rate' => 100,
            ]
        ]);
    }
}
