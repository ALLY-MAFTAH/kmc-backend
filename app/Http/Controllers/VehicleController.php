<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Sticker;
use App\Models\Street;
use App\Models\SubWard;
use App\Models\Vehicle;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;


class VehicleController extends Controller
{
    public function index(Request $request)
    {
        try {

            $sticker_status = $request->get('sticker_status', "All vehicles");
            $type_id = $request->get('type_id', "All Types");
            $latestSticker = [];
            $filteredVehicles = [];


            if ($sticker_status != "All vehicles" && $type_id != "All Types") {
                $allvehicles = vehicle::where('type', $type_id)->get();
                foreach ($allvehicles as $vehicle) {
                    $latestSticker[] = Sticker::where('vehicle_id', $vehicle->id)->latest()->first();
                }
                foreach ($latestSticker as $sticker) {
                    if ($sticker->is_valid == $sticker_status) {
                        $filteredVehicles[] = $sticker->vehicle;
                    }
                }
            } elseif ($sticker_status != "All vehicles") {
                $allvehicles = vehicle::all();
                foreach ($allvehicles as $vehicle) {
                    $latestSticker[] = Sticker::where('vehicle_id', $vehicle->id)->latest()->first();
                }
                foreach ($latestSticker as $sticker) {
                    if ($sticker->is_valid == $sticker_status) {
                        $filteredVehicles[] = $sticker->vehicle;
                    }
                }
            } elseif ($type_id != "All Types") {
                $filteredVehicles = vehicle::whereHas('stickers', function ($fn) use ($type_id) {
                    $fn->where(['type' => $type_id]);
                })->latest()->get();
            } else {
                $filteredVehicles = vehicle::all();
            }

            $vehicles = Vehicle::latest()->get();


            if (REQ::is('api/*'))

                return response()->json(['vehicles' => $vehicles, 'status' => 1], 200);

            return view('vehicles.index', compact('vehicles', 'sticker_status', 'filteredVehicles', 'vehicles'));
        } catch (\Throwable $th) {
            if (REQ::is('api/*'))
                return response()->json(['error' => $th->getMessage(), 'status' => 0], 404);
            alert()->error($th->getMessage());
            return back();
        }
    }
    public function searchVehicle(Request $request)
    {
        try {
            $regNumber = $request->regNumber;

            $vehicle = Vehicle::with(['owner', 'stickers' => function ($query) {
                $query->latest()->take(1);
            }, 'parking' => function ($q) {
                $q->with('location');
            }])->where('reg_number', $regNumber)->first();

            if ($vehicle) {
                return response()->json(["vehicle" => $vehicle, 'status' => 1], 200);
            } else {
                return response()->json(["error" => "No vehicle with that registration number was found!"], 401);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    public function showVehicle(Request $request)
    {
        $vehicles = Vehicle::all();
        $vehicle = Vehicle::where('reg_number', $request->reg_number)->first();

        if (!$vehicle) {
            alert()->error('Vehicle not found');
            return back();
        }
        $amount = 0;
        foreach ($vehicle->payments as $payment) {
            $amount += $payment->amount;
        }

        $subWards = SubWard::where('status', 1)->get();
        $wards = Ward::where('status', 1)->get();
        $provinces = Province::where('status', 1)->get();

        $query = $request->input('query');
        $streets = Street::where('name', 'like', '%' . $query . '%')->get();
        $latestSticker = Sticker::where('vehicle_id', $vehicle->id)->latest()->first();
        $stickers = Sticker::where('vehicle_id', $vehicle->id)->latest()->get();

        return view('vehicles.show', compact('vehicle', 'vehicles', 'stickers', 'amount', 'latestSticker', 'streets', 'subWards', 'wards', 'provinces'));
    }
}
