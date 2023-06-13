<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Vehicle;
use App\Models\Sticker;
use Illuminate\Http\Request;

class StickerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stickers = Sticker::latest()->get();
        $vehicles = Vehicle::all();
        $sticker_status = $request->get('sticker_status', "All Stickers");
        if ($sticker_status != "All Stickers") {

            $stickers = Sticker::where('is_valid', $sticker_status)->latest()->get();
        }

        // dd($sticker_status);
        return view('stickers.index', compact('stickers', 'sticker_status', 'vehicles'));
    }
    public function showSticker(Request $request, Sticker $sticker)
    {
        $vehicles = Vehicle::all();
        return view('stickers.show', compact('sticker', 'vehicles'));
    }
    public function postSticker(Request $request)
    {
        try {
            $stickerRequest = new Request([
                'number' => $request->number,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'period' => date('Y') . '/' . date('Y') + 1,
                'vehicle_id' => $request->vehicle_id,
            ]);

            $vehicle = Vehicle::find($request->vehicle_id);
            $sticker = null;
            $stickerResponse =  self::storeSticker($stickerRequest);

            if ($stickerResponse['status'] == true) {
                $sticker = $stickerResponse['data'];
                $vehicle->stickers()->save($sticker);
            } else {
                alert()->error($stickerResponse['data']);
                return back();
            }

            $paymentRequest = new Request([
                'date' => now(),
                'amount' => 36500,
                'sticker_id' => $sticker->id,
                'vehicle_id' => $vehicle->id,
                'receipt_number' => $request->receipt_number,
            ]);
            $paymentController = new PaymentController();
            $payment = null;
            $paymentResponse =  $paymentController->postPayment($paymentRequest);
            if ($paymentResponse['status'] == true) {
                $payment = $paymentResponse['data'];
                $sticker->payment()->save($payment);
                $vehicle->payments()->save($payment);
            } else {
                alert()->error($paymentResponse['data']);
                return back();
            }

            alert()->success('You have successful added sticker');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return redirect()->back();
    }
    public function storeSticker(Request $request)
    {
        try {

            $attributes = $this->validate($request, [
                'number' => 'required |unique:stickers,number,except,id',
                'end_date' => 'required',
                'start_date' => 'required',
                'vehicle_id' => 'required',
            ]);

            $attributes['is_valid'] = true;
            $attributes['is_paid'] = true;
            $attributes['status'] = true;
            $attributes['period'] = $request->period ?? date('Y') . '/' . date('Y') + 1;

            $sticker = Sticker::create($attributes);
            LogActivityHelper::addToLog('Added sticker with number: ' . $sticker->number);

            return ['status' => true, 'data' => $sticker];
        } catch (\Throwable $th) {
            return ['status' => false, 'data' => $th->getMessage()];
        }
        LogActivityHelper::addToLog('Added sticker. Number: ' . $sticker->number);
    }
    public function putSticker(Request $request, Sticker $sticker)
    {
        try {
            $attributes = $this->validate($request, [
                'number' => 'required |unique:stickers,number,' . $sticker->id,
                'end_date' => 'required',
                'start_date' => 'required',
                'vehicle_id' => 'required',

            ]);

            $sticker->update($attributes);
            $attributes = [
                'receipt_number' => $request->receipt_number,
            ];
            $sticker->payment->update($attributes);
            LogActivityHelper::addToLog('Updated sticker ' . $sticker->number);

            alert()->success('You have successful edited sticker');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return redirect()->back();
    }
    public function toggleStatus(Request $request, Sticker $sticker)
    {
        try {
            $attributes = $this->validate($request, [
                'status' => ['required', 'boolean'],
            ]);
            $sticker->update($attributes);
            LogActivityHelper::addToLog('Switched sticker ' . $sticker->number . ' status ');

            alert()->success('You have successfully updated sticker status');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }

    public function deleteSticker(Sticker $sticker)
    {
        try {
            $itsName = $sticker->number;
            $sticker->delete();
            LogActivityHelper::addToLog('Deleted sticker number' . $itsName);

            alert()->success('You have successful deleted sticker number' . $itsName . '.');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
}
