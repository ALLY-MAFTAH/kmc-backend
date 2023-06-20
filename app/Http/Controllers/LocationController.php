<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Location;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{

    public function index()
    {
        $locations = Location::all();

        return view('locations.index', compact('locations'));
    }
    public function showLocation(Request $request, Location $location)
    {
        return view('locations.show', compact('location'));
    }
    public function postLocation(Request $request, $parkingId)
    {
        $attributes = $this->validate($request, [
            'latitude' => "required",
            'longitude' => "required",
            'location_name' => ['required', 'unique:locations'],
        ]);
        $attributes['parking_id']=$parkingId;

        $location = Location::create($attributes);

        LogActivityHelper::addToLog('Added location: ' . $location->latitude . ', ' . $location->longitude);
        return $location;

    }
    public function putLocation(Request $request, Location $location)
    {
        try {
            $validator = Validator::make($request->all(), [
                'location_name' => 'required |unique:locations,location_name,' . $location->id,

            ]);

            if ($validator->fails()) {
                return ['status' => false, 'data' => $validator->errors()->getMessages()];
            }
            $attributes['latitude'] = $request->latitude ?? $location->latitude;
            $attributes['longitude'] = $request->longitude ?? $location->longitude;
            $attributes['location_name'] = $request->location_name ?? $location->location_name;

            $location->update($attributes);
            LogActivityHelper::addToLog('Updated location: ' . $location->latitude . ', ' . $location->longitude);
            return ['status' => true, 'data' => $location];
        } catch (\Throwable $th) {
            return ['status' => false, 'data' => $th->getMessage()];
        }
    }

    public function deleteLocation(Location $location)
    {

        $itsName = $location->location_name;
        $location->delete();
        LogActivityHelper::addToLog('Deleted location ' . $itsName);

        alert()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
