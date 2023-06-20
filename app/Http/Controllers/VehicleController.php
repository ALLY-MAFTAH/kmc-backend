<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Alert;
use App\Models\Driver;
use App\Models\Owner;
use App\Models\Parking;
use App\Models\Province;
use App\Models\Sticker;
use App\Models\Street;
use App\Models\SubWard;
use App\Models\Vehicle;
use App\Models\Ward;
use App\Services\MessagingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;


class VehicleController extends Controller
{
    public function getVehiclesApi(){
        $vehicles = Vehicle::with(['stickers','parking','owner','driver'])-> latest()->get();
        // dd($vehicles);
        return response()->json(['vehicles' => $vehicles, 'status' => 1], 200);

    }
    public function index(Request $request)
    {

        try {
            $sticker_status = $request->get('sticker_status', "All vehicles");
            $type_id = $request->get('type_id', "All Types");
            $latestSticker = [];
            $filteredVehicles = [];


            if ($sticker_status != "All vehicles" && $type_id != "All Types") {
                $allvehicles = vehicle::where('type', $type_id)->get();
                foreach ($allvehicles as $vehicle) {
                    $latestSticker[] = Sticker::where('vehicle_id', $vehicle->id)->latest()->first();
                }
                foreach ($latestSticker as $sticker) {
                    if ($sticker->is_valid == $sticker_status) {
                        $filteredVehicles[] = $sticker->vehicle;
                    }
                }
            } elseif ($sticker_status != "All vehicles") {
                $allvehicles = vehicle::all();
                foreach ($allvehicles as $vehicle) {
                    $latestSticker[] = Sticker::where('vehicle_id', $vehicle->id)->latest()->first();
                }
                foreach ($latestSticker as $sticker) {
                    if ($sticker->is_valid == $sticker_status) {
                        $filteredVehicles[] = $sticker->vehicle;
                    }
                }
            } elseif ($type_id != "All Types") {
                $filteredVehicles = vehicle::whereHas('stickers', function ($fn) use ($type_id) {
                    $fn->where(['type' => $type_id]);
                })->latest()->get();
            } else {
                $filteredVehicles = vehicle::all();
            }

            $vehicles = Vehicle::with('stickers')->with('parking')-> latest()->get();
            $parkings = Parking::all();
            $drivers = Driver::whereDoesntHave('vehicle')->get();
            $owners = Owner::all();

            return view('vehicles.index', compact('vehicles', 'sticker_status', 'parkings', 'drivers', 'owners', 'filteredVehicles', 'vehicles'));
        } catch (\Throwable $th) {
            if (REQ::is('api/*'))
                return response()->json(['error' => $th->getMessage(), 'status' => 0], 404);
            alert()->error($th->getMessage());
            return back();
        }
    }
    public function searchVehicle(Request $request)
    {
        try {
            $regNumber = $request->regNumber;

            $vehicle = Vehicle::with(['owner','driver', 'stickers' => function ($query) {
                $query->latest()->take(1);
            }, 'parking' => function ($q) {
                $q->with('location');
            }])->where('reg_number', $regNumber)->first();

            if ($vehicle) {
                return response()->json(["vehicle" => $vehicle, 'status' => 1], 200);
            } else {
                return response()->json(["error" => "No vehicle with that registration number was found!"], 401);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 404);
        }
    }

    public function showVehicle(Request $request)
    {
        $vehicles = Vehicle::all();
        $vehicle = Vehicle::where('reg_number', $request->reg_number)->first();

        if (!$vehicle) {
            alert()->error('Vehicle not found');
            return back();
        }
        $amount = 0;
        foreach ($vehicle->payments as $payment) {
            $amount += $payment->amount;
        }
        $parkings = Parking::where('status', 1)->get();
        $drivers = Driver::all();
        $owners = Owner::all();

        $query = $request->input('query');
        $latestSticker = Sticker::with('payment')->where('vehicle_id', $vehicle->id)->latest()->first();

        $stickers = Sticker::where('vehicle_id', $vehicle->id)->latest()->get();

        return view('vehicles.show', compact('vehicle', 'parkings', 'drivers', 'owners', 'vehicles', 'stickers', 'amount', 'latestSticker'));
    }

    public function postVehicle(Request $request)
    {
        try {
            $customMessages = [
                'reg_number.unique' => 'The registration number is already taken.'
            ];

            $attributes = $this->validate($request, [
                'reg_number' => ['required', 'unique:vehicles,reg_number,NULL,id,deleted_at,NULL'],
                "color" => 'required',
                "type" => 'required',
                "brand" => 'required',
                "parking_id" => 'required',
                "owner_id" => 'nullable',
                "driver_id" => 'nullable',
            ], $customMessages);

            $vehicle = Vehicle::create($attributes);
            LogActivityHelper::addToLog('Added vehicle with registration number: ' . $vehicle->reg_number);

            $stickerRequest = new Request([
                "number" => $request->number,
                "start_date" => $request->start_date,
                "end_date" => $request->end_date,
                "vehicle_id" => $vehicle->id,
            ]);

            $stickerController = new StickerController();
            $sticker = null;
            $stickerResponse = $stickerController->storeSticker($stickerRequest);

            if ($stickerResponse['status'] == true) {
                $sticker = $stickerResponse['data'];
                $vehicle->stickers()->save($sticker);
            } else {
                alert()->error($stickerResponse['data']);
                return back();
            }

            $paymentRequest = new Request([
                "sticker_id" => $sticker->id,
                "vehicle_id" => $vehicle->id,
                "date" => now(),
                "amount" => 36500,
                "receipt_number" => $request->receipt_number,
            ]);
            $paymentController = new PaymentController();
            $payment = null;
            $paymentResponse = $paymentController->postPayment($paymentRequest);

            if ($paymentResponse['status'] == true) {
                $payment = $paymentResponse['data'];
                $vehicle->payments()->save($payment);
                $sticker->payment()->save($payment);
            } else {
                alert()->error($paymentResponse['data']);
                return back();
            }

            alert()->success('Vehicle registered successful');
            return back();
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }
    public function putVehicle(Request $request, Vehicle $vehicle)
    {
        $oldVehicleRegNumber = $vehicle->reg_number;
        try {
            $customMessages = [
                'reg_number.unique' => 'The registration number is already taken.'
            ];

            $attributes = $this->validate($request, [
                'reg_number' => 'required |unique:vehicles,reg_number,' . $vehicle->id,
                "color" => 'required',
                "type" => 'required',
                "brand" => 'required',
                "parking_id" => 'required',
                "owner_id" => 'nullable',
                "driver_id" => 'nullable',
            ], $customMessages);

            $vehicle->update($attributes);
            LogActivityHelper::addToLog('Edted vehicle with registration number: ' . $vehicle->reg_number);

            alert()->success('Vehicle edited successful');
            if ($oldVehicleRegNumber == $vehicle->reg_number) {
                return back();
            } else {
                return self::index($request);
            }
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }

    public function toggleStatus(Request $request, Vehicle $vehicle)
    {
        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $vehicle->update($attributes);
        LogActivityHelper::addToLog('Switched status of vehicle with reg.number: ' . $vehicle->reg_number);

        alert()->success('Vehicle status updated successfully');
        return back();
    }

    public function deleteVehicle(Vehicle $vehicle)
    {
        $itsName = $vehicle->reg_number;
        $vehicle->delete();
        LogActivityHelper::addToLog('Deleted vehicle with Reg. Number: ' . $itsName);

        alert()->success('Vehicle deleted successful');
        return back();
    }


}
