<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Location;
use App\Models\Business;
use App\Models\Source;
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
        $locations = Location::all();
        $businesses = Business::orderBy('tin')->get();

        return view('locations.index', compact('locations', 'businesses'));
    }
    public function showLocation(Request $request, Location $location)
    {
        return view('locations.show', compact('location'));
    }
    public function postLocation(Request $request)
    {
        $attributes = $this->validate($request, [
            'business_id' => 'required',

        ]);
        // dd($attributes);
        $attributes['latitude'] = $request->latitude ?? "";
        $attributes['longitude'] = $request->longitude ?? "";
        $attributes['description'] = $request->description ?? "";

        $location = Location::create($attributes);

        LogActivityHelper::addToLog('Added location: ' . $location->latitude . ', ' . $location->longitude);
        return $location;

        notify()->success('You have successful added location');

        return redirect()->back();
    }
    public function putLocation(Request $request, Location $location)
    {
        $attributes['latitude'] = $request->latitude ?? "";
        $attributes['longitude'] = $request->longitude ?? "";
        $attributes['description'] = $request->description ?? "";

        $loc =  $location->update($attributes);
        LogActivityHelper::addToLog('Updated location: ' . $location->latitude . ', ' . $location->longitude);

        notify()->success('You have successful edited location');
        return redirect()->back();
    }

    public function deleteLocation(Location $location)
    {

        $itsName = $location->name;
        $location->delete();
        LogActivityHelper::addToLog('Deleted location ' . $itsName);

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
