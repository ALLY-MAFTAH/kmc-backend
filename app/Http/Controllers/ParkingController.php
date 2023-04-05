<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $parkings = Parking::with('location')->where('status', 1)->latest()->get();

            return response()->json(['parkings' => $parkings, 'status' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'status' => 0], 404);
        }
    }

    public function postParking(Request $request)
    {
        $lastRow = Parking::latest()->first();

        $lastPln = $lastRow ? $lastRow->pln : "KMCTNTM/000";
        [$prefix, $numeric] = explode('/', $lastPln);
        $newNumeric = str_pad((int)$numeric + 1, strlen($numeric), '0', STR_PAD_LEFT);
        $newPln = "$prefix/$newNumeric";
        $newRequest = $request->merge(['pln' => $newPln]);

        try {
            $attributes = $this->validate($newRequest, [
                'pln' => ['required', 'unique:parkings'],
                "street_id" => 'required',
                "ward_id" => 'required',
                "capacity" => 'required',
                "no_of_vehicles" => 'required',
                "leader_mobile" => 'required',
                "leader_name" => 'required',
                "latitude" => 'required',
                "longitude" => 'required',
                'location_name' => ['required', 'unique:locations'],
            ]);
            $attributes['status'] = true;
            $attributes['name'] = $newRequest->name ?? "";
            // dd($attributes);
            $parking = Parking::create($attributes);

            $locationController = new LocationController();
            $location = $locationController->postLocation($request, $parking->id);

            return response()->json([
                'parking' => $parking,
                'location' => $location,
                'status' => 1,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 201);
        }
    }
}
