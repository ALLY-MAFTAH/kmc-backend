<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Alert;
use App\Models\Business;
use App\Models\Licence;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alerts = Alert::all();
        $businesses = Business::orderBy('tin')->get();
        return view('alerts.index', compact('alerts', 'businesses'));
    }
    public function showAlert(Request $request, Alert $alert)
    {
        return view('alerts.show', compact('alert'));
    }
    public function postAlert(Request $request)
    {
        $business = Business::findOrFail($request->business_id);
        $licence = Licence::findOrFail($request->licence_id);
        $attributes = $this->validate($request, [
            'msg' => 'required',
            'date' => 'required',
            'category' => 'required',
            'licence_id' => 'required',
            'business_id' => 'required',
        ]);

        $alert = Alert::create($attributes);
        $business->alerts()->save($alert);
        $licence->alerts()->save($alert);

        LogActivityHelper::addToLog('Added alert ' . $alert->msg);

        notify()->success('You have successful added alert');

        return redirect()->back();
    }
    public function putAlert(Request $request, Alert $alert)
    {
        $attributes = $this->validate($request, [
            'msg' => 'required',
            'date' => 'required',
            'category' => 'required',
            'licence_id' => 'required',
            'business_id' => 'required',

        ]);

        $alert->update($attributes);
        LogActivityHelper::addToLog('Updated alert ' . $alert->msg);

        notify()->success('You have successful edited alert');
        return redirect()->back();
    }

    public function deleteAlert(Alert $alert)
    {

        $itsName = $alert->number;
        $alert->delete();
        LogActivityHelper::addToLog('Deleted alert ' . $itsName);

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
