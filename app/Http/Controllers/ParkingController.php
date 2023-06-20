<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Alert;
use App\Models\Parking;
use App\Models\Province;
use App\Models\Sticker;
use App\Models\Vehicle;
use App\Models\Ward;
use App\Services\MessagingService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request as REQ;

class ParkingController extends Controller
{

    public function index(Request $request)
    {
        try {

            $type_id = $request->get('type_id', "All Types");

            $parkings = Parking::with('location')->with('vehicles')->where('status', 1)->latest()->get();
            $vehicles = Vehicle::all();

            if (REQ::is('api/*'))
                return response()->json(['parkings' => $parkings, 'status' => 1], 200);
            return view('parkings.index', compact('parkings','vehicles'));
        } catch (\Throwable $th) {
            if (REQ::is('api/*'))
                return response()->json(['error' => $th->getMessage(), 'status' => 0], 404);
            alert()->error($th->getMessage());
            return back();
        }
    }

    public function showParking(Request $request)
    {
        $vehicles = Vehicle::all();
        $parking = Parking::find($request->parking_id);

        if (!$parking) {
            alert()->error('Parking not found');
            return back();
        }

        $amount = 0;
        foreach ($parking->vehicles as $vehicle) {
            foreach ($vehicle->payments as $payment) {
                $amount += $payment->amount;
            }
        }

        return view('parkings.show', compact('parking', 'vehicles', 'amount'));
    }

    public function postParking(Request $request)
    {
        // dd($request->all());
        $lastRow = Parking::latest()->first();

        $lastPln = $lastRow ? $lastRow->pln : "KMCTNTM/000";
        [$prefix, $numeric] = explode('/', $lastPln);
        $newNumeric = str_pad((int)$numeric + 1, strlen($numeric), '0', STR_PAD_LEFT);
        $newPln = "$prefix/$newNumeric";
        $newRequest = $request->merge(['pln' => $newPln]);

        try {
            $attributes = $this->validate($newRequest, [
                'pln' => ['required', 'unique:parkings'],
                "capacity" => 'required',
                "leader_mobile" => 'required',
                "leader_name" => 'required',
                "latitude" => 'required',
                "longitude" => 'required',
                'location_name' => ['required', 'unique:locations'],
                "ward" => 'required',
                "sub_ward" => 'required',
            ]);
            $now = Carbon::now()->format('Ymd-His');

            if ($request->hasFile('leader_photo')) {

                $photoPath = $request->file('leader_photo')->storeAs(
                    '/images',
                    'profile-img-' . $now . '.' . $request->file('leader_photo')->getClientOriginalExtension(),
                    'public'
                );
            } else {
                $photoPath = "";
            }

            $attributes['status'] = true;
            $attributes['name'] = $newRequest->name ?? $newRequest->pln;
            $attributes['leader_photo'] = $photoPath;

            $parking = Parking::create($attributes);

            $locationController = new LocationController();
            $location = $locationController->postLocation($request, $parking->id);

            $parking->location()->save($location);
            if (REQ::is('api/*'))
                return response()->json([
                    'parking' => $parking,
                    'location' => $location,
                    'status' => 1,
                ], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 201);
        }
    }
    public function putParking(Request $request)
    {
        $parking = Parking::find($request->parking_id);

        try {
            $attributes = $this->validate($request, [
                "capacity" => 'required',
                "leader_name" => 'required',
                "leader_mobile" => 'required',
                "ward" => 'required',
                "sub_ward" => 'required',
            ]);
            $now = Carbon::now()->format('Ymd-His');

            if ($request->hasFile('leader_photo')) {

                $photoPath = $request->file('leader_photo')->storeAs(
                    '/images',
                    'profile-img-' . $now . '.' . $request->file('leader_photo')->getClientOriginalExtension(),
                    'public'
                );
            } else {
                $photoPath = $parking->leader_photo;
            }
            $attributes['status'] = true;
            $attributes['name'] = $request->name ?? $parking->pln;
            $attributes['leader_photo'] = $photoPath;

            $parking->update($attributes);

            $location = null;
            $locationController = new LocationController();

            $locationResponse = $locationController->putLocation($request, $parking->location);

            if ($locationResponse['status'] == true) {
                $location = $locationResponse['data'];
                $parking->location()->save($location);
            } else {
                if (REQ::is('api/*'))
                    return  response()->json([
                        'error' => $locationResponse['data'],
                        'status' => false
                    ]);
                alert()->error($locationResponse['data']);
                return back();
            }
            if (REQ::is('api/*'))
                return response()->json([
                    'parking' => $parking,
                    'location' => $location,
                    'status' => true,
                ], 200);
            alert()->success("Parking edited successful");
            return back();
        } catch (\Throwable $th) {
            if (REQ::is('api/*'))
                return  response()->json([
                    'error' => $th->getMessage(),
                    'status' => false
                ]);
            alert()->error($th->getMessage());
            return back();
        }
    }
    public function changeProfile(Request $request, Parking $parking)
    {
        $now = Carbon::now()->format('Ymd-His');

        if ($request->hasFile('leader_photo')) {

            $photoPath = $request->file('leader_photo')->storeAs(
                '/images',
                'profile-img-' . $now . '.' . $request->file('leader_photo')->getClientOriginalExtension(),
                'public'
            );
        } else {
            alert()->error('No image choosen');
            return back();
        }

        $attributes['leader_photo'] = $photoPath;

        $parking->update($attributes);

        alert()->success('Profile picture successfull updated');

        return back();
    }
    public function sendMessage(Request $request)
    {
        $parking = Parking::find($request->parking_id);

        $messagingService = new MessagingService();
        $sendMessageResponse = $messagingService->sendMessage($parking->leader_mobile, $request->body);

        if ($sendMessageResponse['status'] == "Sent") {

            $attributes['category'] = 'Reminder';
            $attributes['date'] = Carbon::now();
            $attributes['msg'] = $sendMessageResponse['msg'];
            $attributes['mobile'] = $sendMessageResponse['mobile'];
            $attributes['parking_id'] = $parking->id;

            $alert = Alert::create($attributes);
            $parking->alerts()->save($alert);

            LogActivityHelper::addToLog('Added alert message: ' . $alert->msg . " to : " . $alert->mobile);
            LogActivityHelper::addToLog('Sent sms to parking leader. Number: ' . $parking->leader_mobile);
            alert()->success('Message successful sent.');
        } else {
            alert()->error('Message not sent, crosscheck your inputs');
        }
        return back();
    }

    public function viewLeaderPhoto($parkingId)
    {
        $parking = Parking::find($parkingId);
        if (!$parking) {
            return response()->json([
                'error' => 'Parking not found'
            ], 404);
        }

        $pathToFile = storage_path('/app/public/' . $parking->leader_photo);
        return response()->download($pathToFile);
    }
    public function deleteParking(Parking $parking){

        $parking->delete();
        alert()->success('Parking deleted successful');
        return back();
    }
}
