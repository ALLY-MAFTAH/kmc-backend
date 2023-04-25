<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\Sticker;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            $sticker_status = $request->get('sticker_status', "All Parkings");
            $type_id = $request->get('type_id', "All Types");
            $latestSticker = [];
            $filteredParkings = [];


            if ($sticker_status != "All Parkings" && $type_id != "All Types") {
                $allParkings = Parking::where('type_id', $type_id)->get();
                foreach ($allParkings as $business) {
                    $latestSticker[] = Sticker::where('business_id', $business->id)->latest()->first();
                }
                foreach ($latestSticker as $sticker) {
                    if ($sticker->is_valid == $sticker_status) {
                        $filteredParkings[] = $sticker->business;
                    }
                }
            } elseif ($sticker_status != "All Parkings") {
                $allParkings = Parking::all();
                foreach ($allParkings as $business) {
                    $latestSticker[] = Sticker::where('business_id', $business->id)->latest()->first();
                }
                foreach ($latestSticker as $sticker) {
                    if ($sticker->is_valid == $sticker_status) {
                        $filteredParkings[] = $sticker->business;
                    }
                }
            } elseif ($type_id != "All Types") {
                $filteredParkings = Parking::whereHas('stickers', function ($fn) use ($type_id) {
                    $fn->where(['type_id' => $type_id]);
                })->latest()->get();
            } else {
                $filteredParkings = Parking::all();
            }

            $parkings = Parking::with('location')->where('status', 1)->latest()->get();
            $vehicles = Vehicle::all();

            if (REQ::is('api/*'))

                return response()->json(['parkings' => $parkings, 'status' => 1], 200);

            return view('parkings.index', compact('parkings', 'sticker_status','filteredParkings','vehicles'));

        } catch (\Throwable $th) {
            if (REQ::is('api/*'))
                return response()->json(['error' => $th->getMessage(), 'status' => 0], 404);
            alert()->error($th->getMessage());
            return back();
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
            $attributes['name'] = $newRequest->name ?? $newRequest->pln;
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
