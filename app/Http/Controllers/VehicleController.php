<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();

        return view('vehicles.index', compact('vehicles'));
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
}
