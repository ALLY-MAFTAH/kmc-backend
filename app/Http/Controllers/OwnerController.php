<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Parking;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Storage;
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
        return view('owners.index', compact('owners', 'vehicles', 'parkings'));
    }
    public function showOwner(Owner $owner)
    {

        $owner = Owner::find($owner->id);
        $vehicles = Vehicle::all();
        $parkings = Parking::all();
        $amount = 0;
        foreach ($owner->vehicles as $vehicle) {
            foreach ($vehicle->payments as $payment) {
                $amount += $payment->amount;
            }
        }
        if (REQ::is('api/*'))
            return response()->json([
                'owner' => $owner,
                'status' => true
            ], 200);
        return view('owners.show', compact('owner', 'amount', 'vehicles', 'parkings'));
    }

    public function postOwner(Request $request)
    {
        $photoPath = null;

        $validator = Validator::make($request->all(), [
            'nida' => 'required |unique:owners,nida,except,id',
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
        alert()->success('Qwner registered successfully');
        return back();
    }
    public function putOwner(Request $request, Owner $owner)
    {

        $photoPath = null;
        try {

            $validator = Validator::make($request->all(), [
                'nida' => 'required |unique:owners,nida,' . $owner->id,
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
            $ownerPhotoToDelete = $owner->photo;

            $now = Carbon::now()->format('Ymd-His');
            // dd($exe);
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->storeAs(
                    '/images',
                    'profile-img-' . $now . '.' . $request->file('photo')->getClientOriginalExtension(),
                    'public'
                );
                Storage::disk('public')->delete($ownerPhotoToDelete);
            } else {
                $photoPath = $owner->photo;
            }
            Storage::disk('public')->move($owner->photo, $photoPath);

            $owner->update([
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'mobile' => $request->input('mobile'),
                'nida' => $request->input('nida'),
                'photo' => $photoPath
            ]);
            $owner->save();

            if (REQ::is('api/*'))
                return response()->json([
                    'owner' => $owner
                ], 206);
            alert()->success('Owner edited successful');
            return back();
            //code...
        } catch (\Throwable $th) {
            alert()->error($th);
            return back()->withErrors($validator)->withInput();
        }
    }
    public function deleteOwner(Owner $owner)
    {
        try {
            $owner->delete();
            Storage::disk('public')->delete($owner->photo);

            if (REQ::is('api/*'))
                return response()->json([
                    'owner' => 'Owner deleted successfully'
                ], 200);
            alert()->success('Owner deleted successful');
            return back();
        } catch (\Throwable $th) {
            alert()->error($th);
            return back();
        }
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
