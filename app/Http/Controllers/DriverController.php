<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Parking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $drivers = Driver::all();
        $vehicles = Vehicle::all();
        $parkings = Parking::all();
        if (REQ::is('api/*'))
            return response()->json([
                'drivers' => $drivers,
                'status' => true
            ], 200);
        return view('drivers.index', compact('drivers', 'vehicles', 'parkings'));
    }


    public function postDriver(Request $request)
    {
        $photoPath = null;

        // Validate if the request sent contains this parameters
        $validator = Validator::make($request->all(), [
            'nida' => 'required',
            'mobile' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'photo' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->getMessageBag(),
                'status' => false
            ], 401);
        }

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->storeAs(
                config('app.name') . '/IMAGES/',
                $request->first_name . $request->last_name . '.' . $request->file('photo')->getClientOriginalExtension(),
                'public'
            );
        } else $photoPath = "";

        $driver = new Driver();
        $driver->first_name = $request->input('first_name');
        $driver->middle_name = $request->input('middle_name') ?? "";
        $driver->last_name = $request->input('last_name');
        $driver->mobile = $request->input('mobile');
        $driver->nida = $request->input('nida');
        $driver->photo = $photoPath;

        $driver->save();
        if (REQ::is('api/*'))
            return response()->json([
                'driver' => $driver
            ], 201);
        return back()->with('success', 'Qwner registered successfully');
    }

    public function viewDriverPhoto($driverId)
    {
        try {
            $driver = Driver::find($driverId);
            if (!$driver) {
                return response()->json([
                    'error' => 'Driver not found'
                ], 404);
            }

            $pathToFile = storage_path('/app/public/' . $driver->photo);
            return response()->download($pathToFile);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 404);
        }
    }
}
