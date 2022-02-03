<?php

namespace App\Http\Controllers\api;

use App\Models\ParkingLotDetail;
use App\Models\ParkingSlotType;
use App\Models\ParkingLotTile;
use App\Models\ParkingLotEntrance;
use App\Models\ParkingSlotTransaction;
use App\Http\Requests\ParkCarRequest;
use App\Http\Requests\UnparkCarRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class ParkingSlotTransactionController extends Controller
{
    public function getNearestParkingSlot($parking_id, $entry_id, $type_id) {
        try {
            ParkingSlotType::findOrFail($type_id); // to check if type id exist.

            $entry = ParkingLotEntrance::whereHas('tile', function ($q) use ($parking_id){
                    return $q->where('parking_lot_detail_id', $parking_id);
                })->where('id', $entry_id)
                ->firstOrFail();

                $sorted_nearest =  $entry->distance()->with('slot_detail')
                ->join('parking_slot_details', function ($join)use ($type_id) {
                    $join->on('parking_slot_details.id', '=', 'parking_slot_detail_id')
                        ->where('is_occupied', 0)
                        ->where('parking_slot_type_id', '>=', $type_id);
                })
                ->where('distance','>',-1)
                ->orderBy('parking_slot_type_id', 'asc')
                ->orderBy('distance', 'asc')
                ->get();

            if(count($sorted_nearest) < 1)
                abort(400, 'No available slot!');

            $nearest = $sorted_nearest[0];
            return response()->json([
                'data' => [
                    'type' => $nearest->slot_detail->slot_type->vehicle_size,
                    'tile_id' => $nearest->slot_detail->parking_lot_tile_id,
                    'slot_detail_id' => $nearest->slot_detail->id,
                    'type_id' => $nearest->slot_detail->slot_type->id,
                    'distance' => $nearest->distance,
                    'entrance_name' => $entry->name,
                ]
            ]);

            // return $a->map(function ($item) use ($entry) {
            //     return [
            //         'is_occupied' => $item->slot_detail->is_occupied,
            //         'type' => $item->slot_detail->slot_type->vehicle_size,
            //         'tile_id' => $item->slot_detail->parking_lot_tile_id,
            //         'type_id' => $item->slot_detail->slot_type->id,
            //         'distance' => $item->distance,
            //         'entrance_name' => $entry->name,
            //     ];
            // });
           
        } catch(ModelNotFoundException $e){
            abort(404, "Cannot find parking entry");
        }
    }

    public function parkCar(ParkCarRequest $request, $pli) {
        try {
            $checkIfCarIsParked = ParkingSlotTransaction::where('plate_number',$request->plate_number)
                ->where('datetime_out', null)
                ->first();
            if($checkIfCarIsParked)
                abort(400, 'Car is still parked!');

            $tile = ParkingLotTile::where('parking_lot_detail_id', $pli)
                ->whereHas('slot_details', function ($q) {
                        $q->where('is_occupied', 0);
                })
                ->where('is_parking_space', 1)
                ->where('id', $request->tile_id)
                ->firstOrFail();

            $tile->slot_details()->update([
                'is_occupied' => 1,
            ]);

            $newTransaction = $tile->slot_details
                ->transactions()
                ->create($request->only('datetime_in', 'plate_number'));

            return response()->json([
                'data' => $newTransaction,
                'message' => "Car successfully parked!"
            ]);
           
        } catch(ModelNotFoundException $e){
            abort(404, "Unable to park car!");
        }
    }

    public function unparkCar(UnparkCarRequest $request, $pli, $txn_id) {
        try {
            $txn = ParkingSlotTransaction::where('id',$txn_id)
                ->whereHas('slot_details.tile', function ($q) use ($pli) {
                    return $q->where('parking_lot_detail_id', $pli);
                })
                ->where('datetime_out', null)
                ->firstOrFail();
            $slot_details = $txn->slot_details;
            $rate = $slot_details->slot_type->rate;
            $entry = Carbon::parse($txn->datetime_in);
            $out = Carbon::parse($request->datetime_out);

            if($entry->gt($out))
                abort(404, "Invalid date");

            $overnight = 0;
            $total_rate = 40;
            $totalHrs = ceil(floatval($entry->diffInMinutes($out) / 60)) - 1;
            if($totalHrs > 3 && $totalHrs < 24){
                $total_rate = $total_rate + floatval(($totalHrs - 3) * $rate);
            }

            if($totalHrs >= 24) {
                $overnight = floor($totalHrs / 24);
                $total_rate = floatval($overnight * 5000);
                $remaining_hours = $totalHrs - ($overnight * 24);

                $total_rate = $total_rate + floatval($remaining_hours * $rate);
            }

            $txn->update([
                'datetime_out' => $request->datetime_out,
                'total_hrs' => $totalHrs,
                'total_amount' => $total_rate
            ]);

            $txn->slot_details()->update([
                'is_occupied' => 0
            ]);

            return response()->json([
                'message' => 'Thank you for parking with us!',
                'data' => [
                    'overnight_park' => $overnight,
                    'total_rate' => $total_rate,
                    'total_hrs' => $totalHrs,
                ]
            ]);
            // $tile = ParkingLotTile::where('parking_lot_detail_id', $pli)
            //     ->whereHas('slot_details', function ($q) {
            //             $q->where('is_occupied', 0);
            //     })
            //     ->where('is_parking_space', 1)
            //     ->where('id', $request->tile_id)
            //     ->firstOrFail();

            // $tile->slot_details()->update([
            //     'is_occupied' => 1,
            // ]);

            // $newTransaction = $tile->slot_details
            //     ->transactions()
            //     ->create($request->only('datetime_in', 'plate_number'));

            // return response()->json([
            //     'data' => $newTransaction,
            //     'message' => "Car successfully parked!"
            // ]);
           
        } catch(ModelNotFoundException $e){
            abort(404, "Unable to find parking record!");
        }
    }
}
