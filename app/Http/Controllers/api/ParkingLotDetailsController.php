<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkingLotDetail;
use App\Models\ParkingLotTile;
use App\Http\Resources\ParkingLotDetailsResource;
use App\Http\Resources\ParkingLotTilesResource;
use App\Http\Requests\ParkingLotDetailsRequests;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ParkingLotDetailsController extends Controller
{
    public function index()
    {
        return ParkingLotDetailsResource::collection(ParkingLotDetail::all());
    }

    public function show($id) {
        try {
            $parking_lot = ParkingLotDetail::findOrFail($id);
            return response()->json([
                'data' => new ParkingLotDetailsResource($parking_lot),
                'tiles' => ParkingLotTilesResource::collection($parking_lot->tiles()->get())
            ]);
        } catch(ModelNotFoundException $ex) {
            abort(404, "Parking lot not found");
        }
    }

    public function store(ParkingLotDetailsRequests $request)
    {
        $parking_lot_detail = ParkingLotDetail::create($request->all());
        $tiles = intval($request->height) * intval($request->width);
        for($a = 0; $a < $request->height; $a++){
            for($b = 0; $b < $request->width; $b++){
                $parking_lot_detail->tiles()->create([
                    'can_be_entrance' => $a === 0 
                        || $b < 1
                        || $b === intval($request->width - 1)
                        || $a === intval($request->height - 1)
                ]);
            }
        }
        return response()->json([
            'data' => new ParkingLotDetailsResource($parking_lot_detail),
            'message' => 'Parking lot has been added'
        ]);
    }

    public function delete($id)
    {
        try {
            $parking_lot = ParkingLotDetail::findOrFail($id);
            $parking_lot->tiles()->delete();
            $parking_lot->delete();
            return response()->json([
                'message' => 'Parking lot has been deleted',
            ]);
        } catch(ModelNotFoundException $ex) {
            abort(404, "Parking lot not found");
        }
    }
}
