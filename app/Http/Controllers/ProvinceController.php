<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Parking;
use App\Models\Vehicle;
use App\Models\Province;
use App\Models\Source;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = Province::orderBy('name')->get();
        $vehicles = Vehicle::all();
        $parkings = Parking::all();
        return view('provinces.index', compact('provinces', 'parkings', 'vehicles'));
    }
    public function showProvince(Request $request, Province $province)
    {
        $vehicles = Vehicle::orderBy('tin')->get();
        return view('provinces.show', compact('province', 'vehicles'));
    }
    public function postProvince(Request $request)
    {
        try {
            $attributes = $this->validate($request, [
                'name' => 'required |unique:provinces,name,except,id',
            ]);

            $attributes['status'] = true;
            $attributes['description'] = $request->description ?? "";
            $province = Province::create($attributes);
            LogActivityHelper::addToLog('Added province ' . $province->name);

            alert()->success('You have successful added province');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return Redirect::back();
    }
    public function putProvince(Request $request, Province $province)
    {
        try {
            $attributes = $this->validate($request, [
                'name' => 'required |unique:provinces,name,' . $province->id
            ]);

            $attributes['description'] = $request->description ?? "";
            $province->update($attributes);
            LogActivityHelper::addToLog('Updated province ' . $province->name);

            alert()->success('You have successful edited province');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return redirect()->back();
    }
    public function toggleStatus(Request $request, Province $province)
    {
        try {
            $attributes = $this->validate($request, [
                'status' => ['required', 'boolean'],
            ]);
            $province->update($attributes);
            LogActivityHelper::addToLog('Switched province ' . $province->name . ' status ');

            alert()->success('You have successfully updated province status');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
    public function deleteProvince(Province $province)
    {
        try {
            $itsName = $province->name;
            $province->delete();
            LogActivityHelper::addToLog('Deleted province ' . $itsName);

            alert()->success('You have successful deleted ' . $itsName . '.');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
}
