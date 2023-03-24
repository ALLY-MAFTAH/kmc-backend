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
            $number = $request->vehicleNumber;

            // dd($number);
            $vehicle = Vehicle::where('number', $number)->first();

            // FOR TESTING
            if ($number == "T123 AAA") {
                $vehicle = [
                    'id' => 1,
                    'number' => $number,
                    'owner_id' => "Ally Maftah",
                    'start_date' => "2022-04-15",
                    'expiry_date' => "2023-04-15",
                    'type_id' => "Bajaji",
                    'brand' => "TVS",
                    'period' => "2023",
                    'color' => "Blue",
                    'parking_id' => "Manzese Tiptop",
                    'status' => true,
                ];
            } elseif ($number == "T123 BBB") {
                $vehicle = [
                    'id' => 2,
                    'number' => $number,
                    'owner_id' => "Bakari Mwakilambe",
                    'start_date' => "2021-10-05",
                    'expiry_date' => "2022-10-05",
                    'type_id' => "Pikipiki",
                    'brand' => "Boxer",
                    'period' => "2023",
                    'color' => "Black",
                    'parking_id' => "Palm Village",
                    'status' => false,
                ];
            }
            if ($vehicle) {
                return response()->json(['vehicle' => $vehicle], 200);
            } else {
                return response()->json("No vehicle with that number was found!", 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 201);
        }
    }
}
