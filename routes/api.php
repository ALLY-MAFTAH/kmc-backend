<?php

use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\StreetController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\WardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// AUTH ROUTES
Route::post('/auth/login', [App\Http\Controllers\Auth\LoginController::class,'loginApi']);


// VEHICLE ROUTES
Route::get('/vehicles', [VehicleController::class,'getVehiclesApi']);
Route::post('/search-vehicle', [VehicleController::class,'searchVehicle']);

// PARKING ROUTES
Route::get('/parkings', [ParkingController::class,'index']);
Route::post('/register-parking', [ParkingController::class,'postParking']);
Route::post('edit-parking/{parking}', [ParkingController::class, 'putParking']);
Route::post('change_profile/{parking}', [ParkingController::class, 'changeProfile']);
Route::get('parking/leader_photo/{parkingId}', [ParkingController::class, 'viewLeaderPhoto'])->name('book_cover');

// WARDS ROUTES
Route::get('/wards', [WardController::class,'index']);
Route::post('/add-ward', [WardController::class,'postWard']);

// STREETS ROUTES
Route::get('/streets', [StreetController::class,'index']);
Route::post('/add-ward', [StreetController::class,'postStreet']);

// OWNERS ROUTES
Route::get('/owners', [OwnerController::class,'index']);
Route::post('/register-owner', [OwnerController::class,'postOwner']);
Route::get('owner/photo/{ownerId}', [OwnerController::class,'viewOwnerPhoto']);

