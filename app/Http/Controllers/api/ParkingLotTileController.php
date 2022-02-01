<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkingLotTile;
use App\Http\Requests\AddObstacleRequest;
use App\Http\Requests\AddEntranceRequest;
use App\Http\Requests\AddParkingSlotRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ParkingLotTileController extends Controller
{
    public function addObstacle(AddObstacleRequest $request, $pld_id) {
        $plt = ParkingLotTile::where('parking_lot_detail_id', $pld_id)
            ->whereIn('id', $request->tile_ids)
            ->where('is_obstacle', 0)
            ->where('is_open_space', 1)
            ->where('is_parking_space', 0)
            ->update([
                'is_obstacle' => true,
                'is_open_space' => false,
            ]);

        return response()->json([
            'message' => "Obstacle successfully added",
        ]);
    }

    public function addEntrance(AddEntranceRequest $request, $pld_id) {
       // get all tiles for parking lot whereIn ids

        $ids = collect($request->tile_ids);
        $tiles = ParkingLotTile::where('parking_lot_detail_id', $pld_id)
            ->whereIn('id', $ids->map(function ($item) {
                return $item['id'];
            }))
            ->where('is_obstacle', 0)
            ->where('is_open_space', 1)
            ->where('is_parking_space', 0)
            ->get();
        // add to entrance details
        foreach($tiles as $tile) {
            $tile->entrance_details()->create(
                [
                    'name' => $ids->first(function ($item) use ($tile) {
                        return $item['id'] === $tile->id;
                    })['name']
                ]
            );
        }
        // update open space to false & obs
        ParkingLotTile::whereIn('id',$tiles->map(function ($e) {
            return $e->id;
        }))->update([
            'is_obstacle' => false,
            'is_open_space' => false,
        ]);
           
        return response()->json([
            'message' => "Entrances successfully added",
        ]);
    }

    public function addParkingSlot(AddParkingSlotRequest $request, $pld_id) {
        // get all tiles for parking lot whereIn ids
 
         $distance = collect($request->distance);
         $tiles = ParkingLotTile::where('parking_lot_detail_id', $pld_id)
             ->whereIn('id', $distance->map(function ($item) {
                 return $item['id'];
             }))
             ->where('is_obstacle', 0)
             ->where('is_open_space', 1)
             ->where('is_parking_space', 0)
             ->get();
         // add to entrance details
         foreach($tiles as $tile) {
            $slot_details = $tile->slot_details()->create(
                [
                    'parking_slot_type_id' => $request->parking_slot_type,
                ]
            );
            //get distance details from current tile iteration
            $distance_details = $distance->first(function ($item) use ($tile) {
                return $item['id'] === $tile->id;
            });
            $entrance_distances = collect($distance_details['entrance_distances']); // convert to collection
            foreach($entrance_distances as $dst) {
                $slot_details->entrance_distance()->create([
                    'parking_lot_entrance_id' => $dst['id'],
                    'distance' => $dst['distance']
                ]);
            };
         }
         // update open space to false & obs
         ParkingLotTile::whereIn('id',$tiles->map(function ($e) {
             return $e->id;
         }))->update([
             'is_obstacle' => false,
             'is_open_space' => false,
             'is_parking_space' => true,
         ]);
            
         return response()->json([
             'message' => "Parking Slot successfully added",
         ]);
     }
}
