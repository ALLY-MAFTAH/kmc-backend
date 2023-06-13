<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Parking;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Storage;
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
    public function showDriver(Driver $driver)
    {

        $driver = Driver::find($driver->id);
        $vehicles = Vehicle::all();
        $parkings = Parking::all();
        $amount = 0;
        foreach ($driver->vehicles as $vehicle) {
            foreach ($vehicle->payments as $payment) {
                $amount += $payment->amount;
            }
        }
        if (REQ::is('api/*'))
            return response()->json([
                'driver' => $driver,
                'status' => true
            ], 200);
        return view('drivers.show', compact('driver', 'amount', 'vehicles', 'parkings'));
    }

    public function postDriver(Request $request)
    {
        $photoPath = null;

        $validator = Validator::make($request->all(), [
            'nida' => 'required |unique:drivers,nida,except,id',
            'mobile' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'photo' => 'required',
        ]);

        // dd($validator->errors());
        if ($validator->fails()) {
            if (REQ::is('api/*'))
                return response()->json([
                    'error' => $validator->errors()->getMessages(),
                    'status' => false
                ], 401);
            alert()->error($validator->errors()->getMessages());
            return back()->withErrors($validator)->withInput();
        }
        $now = Carbon::now()->format('Ymd-His');

        if ($request->hasFile('photo')) {

            $photoPath = $request->file('photo')->storeAs(
                '/images',
                'profile-img-' . $now . '.' . $request->file('photo')->getClientOriginalExtension(),
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
        alert()->success('Qwner registered successfully');
        return back();
    }
    public function putDriver(Request $request, Driver $driver)
    {

        $photoPath = null;
        try {

            $validator = Validator::make($request->all(), [
                'nida' => 'required |unique:drivers,nida,' . $driver->id,
                'mobile' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
            ]);

            if ($validator->fails()) {
                if (REQ::is('api/*'))
                    return response()->json([
                        'error' => $validator->errors()->getMessages(),
                        'status' => false
                    ], 401);
                alert()->error($validator->errors()->getMessages());
                return back()->withErrors($validator)->withInput();
            }
            $driverPhotoToDelete = $driver->photo;

            $now = Carbon::now()->format('Ymd-His');
            // dd($exe);
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->storeAs(
                    '/images',
                    'profile-img-' . $now . '.' . $request->file('photo')->getClientOriginalExtension(),
                    'public'
                );
                Storage::disk('public')->delete($driverPhotoToDelete);
            } else {
                $photoPath = $driver->photo;
            }
            Storage::disk('public')->move($driver->photo, $photoPath);

            $driver->update([
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'mobile' => $request->input('mobile'),
                'nida' => $request->input('nida'),
                'photo' => $photoPath
            ]);
            $driver->save();

            if (REQ::is('api/*'))
                return response()->json([
                    'driver' => $driver
                ], 206);
            alert()->success('Driver edited successful');
            return back();
            //code...
        } catch (\Throwable $th) {
            alert()->error($th);
            return back()->withErrors($validator)->withInput();
        }
    }
    public function deleteDriver(Driver $driver)
    {
        try {
            $driver->delete();
            Storage::disk('public')->delete($driver->photo);

            if (REQ::is('api/*'))
                return response()->json([
                    'driver' => 'Driver deleted successfully'
                ], 200);
            alert()->success('Driver deleted successful');
            return back();
        } catch (\Throwable $th) {
            alert()->error($th);
            return back();
        }
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
