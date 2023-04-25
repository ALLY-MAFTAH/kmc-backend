<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Business;
use App\Models\Licence;
use App\Models\Province;
use App\Models\Source;
use App\Models\Street;
use App\Models\SubWard;
use App\Models\Type;
use App\Models\Ward;
use App\Services\MailingService;
use App\Services\MessagingService;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /**
     * Display a listing of the rebusiness.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $licence_status = $request->get('licence_status', "All Businesses");
        $type_id = $request->get('type_id', "All Types");
        $latestLicence = [];
        $filteredBusinesses = [];

        $types = Type::all();

        if ($licence_status != "All Businesses" && $type_id != "All Types") {
            $allBusinesses = Business::where('type_id', $type_id)->get();
            foreach ($allBusinesses as $business) {
                $latestLicence[] = Licence::where('business_id', $business->id)->latest()->first();
            }
            foreach ($latestLicence as $licence) {
                if ($licence->is_valid == $licence_status) {
                    $filteredBusinesses[] = $licence->business;
                }
            }
        } elseif ($licence_status != "All Businesses") {
            $allBusinesses = Business::all();
            foreach ($allBusinesses as $business) {
                $latestLicence[] = Licence::where('business_id', $business->id)->latest()->first();
            }
            foreach ($latestLicence as $licence) {
                if ($licence->is_valid == $licence_status) {
                    $filteredBusinesses[] = $licence->business;
                }
            }
        } elseif ($type_id != "All Types") {
            $filteredBusinesses = Business::whereHas('licences', function ($fn) use ($type_id) {
                $fn->where(['type_id' => $type_id]);
            })->latest()->get();
        } else {
            $filteredBusinesses = Business::all();
        }
        $businesses = Business::orderBy('tin')->get();

        return view('businesses.index', compact('businesses', 'licence_status', 'filteredBusinesses', 'type_id', 'types'));
    }

    public function showAddBusinessForm(Request $request)
    {

        $businesses = Business::orderBy('tin')->get();
        $sources = Source::where('status', 1)->get();
        $types = Type::where('status', 1)->get();
        $subWards = SubWard::where('status', 1)->get();
        $wards = Ward::where('status', 1)->get();
        $provinces = Province::where('status', 1)->get();

        $query = $request->input('query');
        $streets = Street::where('name', 'like', '%' . $query . '%')->get();

        return view('businesses.add_form', compact('businesses', 'sources', 'types', 'streets', 'subWards', 'wards', 'provinces'));
    }

    public function showBusiness(Request $request)
    {
        $businesses = Business::orderBy('tin')->get();
        $business = Business::where('tin', $request->tin)->first();

        if (!$business) {
            alert()->error('Business not found');
            return back();
        }
        $amount = 0;
        foreach ($business->payments as $payment) {
            $amount += $payment->amount;
        }
        $sources = Source::where('status', 1)->get();
        $types = Type::where('status', 1)->get();
        $subWards = SubWard::where('status', 1)->get();
        $wards = Ward::where('status', 1)->get();
        $provinces = Province::where('status', 1)->get();

        $query = $request->input('query');
        $streets = Street::where('name', 'like', '%' . $query . '%')->get();
        $latestLicence = Licence::where('business_id', $business->id)->latest()->first();
        $licences = Licence::where('business_id', $business->id)->latest()->get();


        return view('businesses.show', compact('business', 'businesses', 'licences', 'amount', 'latestLicence', 'sources', 'types', 'streets', 'subWards', 'wards', 'provinces'));
    }
    public function postBusiness(Request $request)
    {
        try {
            $streetExists = Street::where('name', $request->street_name)->exists();

            if ($streetExists) {
                $street = Street::where('name', $request->street_name)->first();
            } else {
                $streetController = new StreetController();
                $streetRequest = new Request(['name' => $request->street_name, 'sub_ward_id' => $request->sub_ward_id]);
                $street =  $streetController->postStreet($streetRequest);
            }
            $attributes = $this->validate($request, [
                'tin' => 'required |unique:businesses,tin,except,id',
                'name' => 'required',
                'payerId' => 'required',
                'mobile' => 'required',
                'email' => 'required',
                'nida' => 'required',
                'type_id' => 'required',
                'province_id' => 'required',
                'ward_id' => 'required',
                'sub_ward_id' => 'required',
            ]);
            $attributes['status'] = true;
            $attributes['street_id'] = $street->id;
            $attributes['address'] = $request->address ?? "";
            $attributes['house_number'] = $request->house_number ?? "";
            $business = Business::create($attributes);

            $source = Source::findOrFail($request->source_id);
            $business->sources()->attach($source);

            $type = Type::findOrFail($request->type_id);
            $type->businesses()->save($business);

            $province = Province::findOrFail($request->province_id);
            $province->businesses()->save($business);

            $ward = Ward::findOrFail($request->ward_id);
            $ward->businesses()->save($business);

            $subWard = SubWard::findOrFail($request->sub_ward_id);
            $subWard->businesses()->save($business);

            $locationRequest = new Request([
                'latitude' => $request->latitude ?? "",
                'longitude' => $request->longitude ?? "",
                'description' => $request->description ?? "",
                'business_id' => $business->id,
            ]);
            $locationController = new LocationController();
            $location =  $locationController->postLocation($locationRequest);
            $business->location()->save($location);

            $licenceRequest = new Request([
                'number' => $request->number,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'period' => date('Y') . '/' . date('Y') + 1,
                'business_id' => $business->id,
            ]);
            $licenceController = new LicenceController();
            $licence =  $licenceController->storeLicence($licenceRequest);
            $business->licences()->save($licence);

            $paymentRequest = new Request([
                'date' => now(),
                'amount' => $type->amount,
                'type_id' => $type->id,
                'licence_id' => $licence->id,
                'business_id' => $business->id,
                'receipt_number' => $request->receipt_number,
            ]);
            $paymentController = new PaymentController();
            $payment =  $paymentController->postPayment($paymentRequest);
            $licence->payment()->save($payment);
            $business->payments()->save($payment);
            $type->payments()->save($payment);

            LogActivityHelper::addToLog('Registered new business. Named: ' . $business->name);

            alert()->success('You have successful registered new business');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            alert()->error($th);
        }
        return redirect()->back();
    }
    public function changeTin(Request $request, Business $business)
    {
        try {

            $attribute = [
                'tin' => $request->tin
            ];
            $business->update($attribute);
            LogActivityHelper::addToLog('Edited business tin number, to: ' . $business->tin);

            alert()->success('You have successful edited business tin number');
        } catch (\Throwable $th) {
            alert()->error($th);
        }
        return redirect()->back();
    }
    public function putBusiness(Request $request, Business $business)
    {
        try {
            $streetExists = Street::where('name', $request->street_name)->exists();

            if ($streetExists) {
                $street = Street::where('name', $request->street_name)->first();
            } else {
                $streetController = new StreetController();
                $streetRequest = new Request(['name' => $request->street_name, 'sub_ward_id' => $request->sub_ward_id]);
                $street =  $streetController->postStreet($streetRequest);
            }

            $attributes = $this->validate($request, [
                'tin' => 'required |unique:businesses,tin,' . $business->id,
                'name' => 'required',
                'mobile' => 'required',
                'email' => 'required',
                'ward_id' => 'required',
                'sub_ward_id' => 'required',
                'province_id' => 'required',
                'type_id' => 'required',
                'payerId' => 'required',
                'nida' => 'required',
            ]);

            $attributes['status'] = true;
            $attributes['street_id'] = $street->id;
            $attributes['address'] = $request->address ?? "";
            $attributes['house_number'] = $request->house_number ?? "";

            $business->update($attributes);

            $attributes = [
                'latitude' => $request->latitude ?? "",
                'longitude' => $request->longitude ?? "",
                'description' => $request->description ?? "",
            ];

            $business->location()->update($attributes);

            LogActivityHelper::addToLog('Updated business: ' . $business->name);

            alert()->success('You have successful edited business');
        } catch (\Throwable $th) {
            alert()->error($th);
        }
        return redirect()->back();
    }
    public function toggleStatus(Request $request, Business $business)
    {

        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $business->update($attributes);
        LogActivityHelper::addToLog('Switched business ' . $business->name . ' status ');

        alert()->success('You have successfully updated business status');
        return back();
    }
    public function deleteBusiness(Business $business)
    {

        $itsName = $business->name;
        $business->delete();
        LogActivityHelper::addToLog('Deleted business. Named: ' . $itsName);

        alert()->success('You have successful deleted business. Named: ' . $itsName . '.');
        return back();
    }
    public function getSuggestions(Request $request)
    {
        $query = $request->input('query');
        $suggestions = Street::where('name', 'like', '%' . $query . '%')
            ->get();
        return response()->json($suggestions);
    }

    public function sendEmail(Request $request)
    {
        $business = Business::findOrFail($request->business_id);

        try {
            $mailingService = new MailingService();
            $sendMEmailResponse = $mailingService->sendEmail($business, $request->subject, $request->body);

            LogActivityHelper::addToLog('Sent an email to business. Named: ' . $business->name);
            alert()->success('Email successful sent.');
        } catch (\Throwable $th) {
            alert()->error('Email not sent, crosscheck your inputs');
            alert()->error($th->getMessage());
        }
        return back();
    }
    public function sendMessage(Request $request)
    {
        $business = Business::findOrFail($request->business_id);

        $messagingService = new MessagingService();
        $sendMessageResponse = $messagingService->sendMessage($business, $request->body);

        if ($sendMessageResponse == "Sent") {
            LogActivityHelper::addToLog('Sent sms to business. Named: ' . $business->name);
            alert()->success('Message successful sent.');
        } else {
            alert()->error('Message not sent, crosscheck your inputs');
        }
        return back();
    }
}
