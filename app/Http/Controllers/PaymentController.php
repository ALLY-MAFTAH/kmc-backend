<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Vehicle;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();
        $vehicles = Vehicle::all();

        return view('payments.index', compact('payments', 'vehicles'));
    }
    public function showPayment(Request $request, Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }
    public function postPayment(Request $request)
    {
        // $payment->date = Carbon::parse($attributes['date']);

        $attributes = $this->validate($request, [
            'date' => 'required',
            'amount' => 'required',
            'type_id' => 'required',
            'licence_id' => 'required',
            'receipt_number' => 'required',
            'business_id' => 'required',
        ]);

        $payment = Payment::create($attributes);

        LogActivityHelper::addToLog('Added payment ' . $payment->amount);
        return $payment;
        notify()->success('You have successful added payment');


        return redirect()->back();
    }
    public function putPayment(Request $request, Payment $payment)
    {
        try {
            $attributes = $this->validate($request, [
                'date' => 'required',
                'amount' => 'required',
                'receipt_number' => 'required',
                'type_id' => 'required',
                'licence_id' => 'required',
                'business_id' => 'required',
            ]);

            $payment->update($attributes);
            LogActivityHelper::addToLog('Updated payment ' . $payment->amount);

            notify()->success('You have successful edited payment');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return redirect()->back();
    }

    public function deletePayment(Payment $payment)
    {
        try {
            $itsName = $payment->amount;
            $payment->delete();
            LogActivityHelper::addToLog('Deleted payment ' . $itsName);

            notify()->success('You have successful deleted payment ' . $itsName . '.');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
}
