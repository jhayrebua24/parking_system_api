<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkingLotDetail;
use App\Http\Resources\ParkingLotDetailsResource;
use App\Http\Requests\ParkingLotDetailsRequests;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ParkingLotDetailsController extends Controller
{
    public function index()
    {
        $parking_lot_details = ParkingLotDetail::all();
        return ParkingLotDetailsResource::collection($parking_lot_details);
    }

    public function store(ParkingLotDetailsRequests $request)
    {
        $parking_lot_detail = ParkingLotDetail::create($request->all());
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
