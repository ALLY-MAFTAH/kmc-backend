<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function postLocation(Request $request, $parkingId)
    {
        $attributes = [
            "latitude" => $request->latitude,
            "longitude" => $request->longitude,
            "location_name" => $request->location_name,
            "parking_id" => $parkingId
        ];
        // dd($attributes);
        $location = Location::create($attributes);

        return $location;
    }
}
