<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Business;
use App\Models\Parking;
use App\Models\Province;
use App\Models\Source;
use App\Models\SubWard;
use App\Models\Vehicle;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        $parkings = Parking::all();
        $provinces = Province::where('status', 1)->orderBy('name')->get();
        $wards = Ward::orderBy('name')->get();
        return view('wards.index', compact('wards', 'parkings', 'provinces', 'vehicles'));
    }
    public function showWard(Request $request, Ward $ward)
    {
        $vehicles = Vehicle::all();
        $parkings = Parking::all();
        return view('wards.show', compact('ward', 'vehicles','parkings'));
    }
    public function postWard(Request $request)
    {
        $province = Province::findOrFail($request->province_id);
        try {

            $attributes = $this->validate($request, [
                'name' => 'required |unique:wards,name,except,id',
                'province_id' => 'required',
            ]);

            $attributes['status'] = true;
            $attributes['description'] = $request->description ?? "";
            $ward = Ward::create($attributes);
            $province->wards()->save($ward);

            LogActivityHelper::addToLog('Added ward ' . $ward->name);

            alert()->success('You have successful added ward');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return Redirect::back();
    }
    public function putWard(Request $request, Ward $ward)
    {
        try {
            $attributes = $this->validate($request, [
                'name' => 'required |unique:wards,name,' . $ward->id
            ]);

            $attributes['description'] = $request->description ?? "";
            $ward->update($attributes);
            LogActivityHelper::addToLog('Updated ward ' . $ward->name);

            alert()->success('You have successful edited ward');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return redirect()->back();
    }
    public function toggleStatus(Request $request, Ward $ward)
    {
        try {
            $attributes = $this->validate($request, [
                'status' => ['required', 'boolean'],
            ]);

            $ward->update($attributes);
            LogActivityHelper::addToLog('Switched ward ' . $ward->name . ' status ');

            alert()->success('You have successfully updated ward status');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
    public function deleteWard(Ward $ward)
    {
        try {
            $itsName = $ward->name;
            $ward->delete();
            LogActivityHelper::addToLog('Deleted ward ' . $itsName);

            alert()->success('You have successful deleted ' . $itsName . '.');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }

    public function getWards(Request $request)
    {
        $filteredWards = Ward::where(['status' => 1, 'province_id' => $request->provinceId])->orderBy('name')->get();
        $options = '';
        $options .= '<option value="">' . "--" . '</option>';

        foreach ($filteredWards as $ward) {
            $options .= '<option value="' . $ward->id . '">' . $ward->name . '</option>';
        }
        return response()->json(['filteredWards' => $options]);
    }
}
