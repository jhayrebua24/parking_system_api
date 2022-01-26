<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\ParkingLotDetailsController;

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
    });
});
