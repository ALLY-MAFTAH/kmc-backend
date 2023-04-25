<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Parking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Validator;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $owners = Owner::all();
        $vehicles = Vehicle::all();
        $parkings = Parking::all();
        if (REQ::is('api/*'))
            return response()->json([
                'owners' => $owners,
                'status' => true
            ], 200);
        return view('owners.index',compact('owners','vehicles','parkings'));
    }

    public function postOwner(Request $request)
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

        $owner = new Owner();
        $owner->first_name = $request->input('first_name');
        $owner->middle_name = $request->input('middle_name') ?? "";
        $owner->last_name = $request->input('last_name');
        $owner->mobile = $request->input('mobile');
        $owner->nida = $request->input('nida');
        $owner->photo = $photoPath;

        $owner->save();
        if (REQ::is('api/*'))
            return response()->json([
                'owner' => $owner
            ], 201);
        return back()->with('success', 'Qwner registered successfully');
    }

    public function viewOwnerPhoto($ownerId)
    {
        try {
            $owner = Owner::find($ownerId);
            if (!$owner) {
                return response()->json([
                    'error' => 'Owner not found'
                ], 404);
            }

            $pathToFile = storage_path('/app/public/' . $owner->photo);
            return response()->download($pathToFile);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 404);
        }
    }
}
