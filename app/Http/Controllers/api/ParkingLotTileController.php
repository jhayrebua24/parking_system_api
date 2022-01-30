<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkingLotTile;
use App\Http\Requests\AddObstacleRequest;
use App\Http\Requests\AddEntranceRequest;
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
}
