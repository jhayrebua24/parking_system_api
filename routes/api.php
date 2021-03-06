<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\ParkingLotDetailsController;
use App\Http\Controllers\api\ParkingLotTileController;
use App\Http\Controllers\api\ParkingSlotTransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(function() {
    Route::prefix('parking-lot')->group(function() {
        Route::get('/',[ParkingLotDetailsController::class, "index"]);
        Route::post('/',[ParkingLotDetailsController::class, "store"]);
        Route::delete('/{id}',[ParkingLotDetailsController::class, "delete"]);
        Route::get('/{id}',[ParkingLotDetailsController::class, "show"]);

        Route::get('/{id}/parking-slot/{entryId}/nearest-available-slot/{vehicleTypeId}',[ParkingSlotTransactionController::class, "getNearestParkingSlot"]);
        

        Route::post('/{id}/obstacle',[ParkingLotTileController::class, "addObstacle"]);
        Route::post('/{id}/entrance',[ParkingLotTileController::class, "addEntrance"]);
        Route::post('/{id}/parking-slot',[ParkingLotTileController::class, "addParkingSlot"]);
        Route::post('/{id}/park-car',[ParkingSlotTransactionController::class, "parkCar"]);
        Route::put('/{id}/unpark-car/{txn_id}',[ParkingSlotTransactionController::class, "unparkCar"]);
        
        //
        Route::get('/utils/slot-type',[ParkingLotDetailsController::class, "parkingSlotType"]);
    });
});
