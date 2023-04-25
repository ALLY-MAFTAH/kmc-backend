<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Business;
use App\Models\Parking;
use App\Models\Source;
use App\Models\Street;
use App\Models\SubWard;
use App\Models\Vehicle;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class SubWardController extends Controller
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
        $wards = Ward::where('status', 1)->orderBy('name')->get();
        $subWards = SubWard::orderBy('name')->orderBy('name')->get();
        return view('sub_wards.index', compact('subWards', 'parkings', 'wards', 'vehicles'));
    }
    public function showSubWard(Request $request, SubWard $subWard)
    {
        $vehicles = Vehicle::all();
        $parkings = Parking::all();

        return view('sub_wards.show', compact('subWard', 'vehicles', 'parkings'));
    }
    public function postSubWard(Request $request)
    {
        $ward = Ward::findOrFail($request->ward_id);
        try {
            $attributes = $this->validate($request, [
                'name' => ['required', Rule::unique('sub_wards', 'name')->whereNull('deleted_at')],
                'ward_id' => 'required',
            ]);

            $attributes['status'] = true;
            $attributes['description'] = $request->description ?? "";
            $subWard = SubWard::create($attributes);
            $ward->subWards()->save($subWard);

            LogActivityHelper::addToLog('Added sub-ward ' . $subWard->name);

            alert()->success('You have successful added subWard');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }

        return Redirect::back();
    }
    public function putSubWard(Request $request, SubWard $subWard)
    {
        try {
            $attributes = $this->validate($request, [
                'name' => 'required |unique:sub_wards,name,' . $subWard->id

            ]);

            $attributes['description'] = $request->description ?? "";
            $subWard->update($attributes);
            LogActivityHelper::addToLog('Updated sub-ward ' . $subWard->name);

            alert()->success('You have successful edited sub-ward');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return redirect()->back();
    }
    public function toggleStatus(Request $request, SubWard $subWard)
    {
        try {
            $attributes = $this->validate($request, [
                'status' => ['required', 'boolean'],
            ]);

            $subWard->update($attributes);
            LogActivityHelper::addToLog('Switched sub-ward ' . $subWard->name . ' status ');

            alert()->success('You have successfully updated sub-ward status');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
    public function deleteSubWard(SubWard $subWard)
    {
        try {
            $itsName = $subWard->name;
            $subWard->delete();
            LogActivityHelper::addToLog('Deleted sub-ward ' . $itsName);

            alert()->success('You have successful deleted ' . $itsName . '.');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
    public function getSubWards(Request $request)
    {
        $filteredSubWards = SubWard::where(['status' => 1, 'ward_id' => $request->wardId])->orderBy('name')->get();
        $options = '';
        $options .= '<option value="">' . "--" . '</option>';
        foreach ($filteredSubWards as $subWard) {
            $options .= '<option value="' . $subWard->id . '">' . $subWard->name . '</option>';
        }
        return response()->json(['filteredSubWards' => $options]);
    }
}
