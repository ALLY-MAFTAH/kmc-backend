<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Parking;
use App\Models\Street;
use App\Models\SubWard;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class StreetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subWards = SubWard::where('status', 1)->orderBy('name')->get();
        $streets = Street::orderBy('name')->orderBy('name')->get();
        $vehicles = Vehicle::all();
        $parkings = Parking::all();
        return view('streets.index', compact('streets', 'vehicles', 'subWards', 'parkings'));
    }
    public function showStreet(Request $request, Street $street)
    {
        $sticker_status = $request->get('sticker_status', "All Parkings");
        $type_id = $request->get('type_id', "All Types");

        $filteredParkings = Parking::where('street_id', $street->id)->get();


        if ($sticker_status != "All Parkings" && $type_id != "All Types") {
            $filteredParkings = Parking::whereHas('stickers', function ($fn) use ($street, $sticker_status, $type_id) {
                $fn->where(['street_id' => $street->id, 'is_valid' => $sticker_status, 'type_id' => $type_id]);
            })->latest()->get();
        } elseif ($sticker_status != "All Parkings") {
            $filteredParkings = Parking::whereHas('stickers', function ($fn) use ($street, $sticker_status) {
                $fn->where(['street_id' => $street->id, 'is_valid' => $sticker_status]);
            })->latest()->get();
        } elseif ($type_id != "All Types") {
            $filteredParkings = Parking::whereHas('stickers', function ($fn) use ($street, $type_id) {
                $fn->where(['street_id' => $street->id, 'type_id' => $type_id]);
            })->latest()->get();
        }
        $parkings = Parking::where('status', 1)->get();
        $vehicles = Vehicle::all();

        return view('streets.show', compact('street', 'parkings','vehicles', 'sticker_status', 'filteredParkings'));
    }
    public function postStreet(Request $request)
    {
        try {
            $subWard = SubWard::findOrFail($request->sub_ward_id);
            $attributes = $this->validate($request, [
                'name' => ['required', Rule::unique('streets', 'name')->whereNull('deleted_at')],
                'sub_ward_id' => 'required',
            ]);

            $attributes['status'] = true;
            $attributes['description'] = $request->description ?? "";
            $street = Street::create($attributes);
            $subWard->streets()->save($street);
            LogActivityHelper::addToLog('Added street ' . $street->name);
            return $street;

            alert()->success('You have successful added street');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return Redirect::back()->with('street', $street);
    }
    public function putStreet(Request $request, Street $street)
    {
        try {
            $attributes = $this->validate($request, [
                'name' => 'required |unique:streets,name,' . $street->id

            ]);

            $attributes['description'] = $request->description ?? "";
            $street->update($attributes);
            LogActivityHelper::addToLog('Updated street ' . $street->name);

            alert()->success('You have successful edited street');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return redirect()->back();
    }
    public function toggleStatus(Request $request, Street $street)
    {
        try {
            $attributes = $this->validate($request, [
                'status' => ['required', 'boolean'],
            ]);

            $street->update($attributes);
            LogActivityHelper::addToLog('Switched street ' . $street->name . ' status ');

            alert()->success('You have successfully updated street status');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
    public function deleteStreet(Street $street)
    {
        try {
            $itsName = $street->name;
            $street->delete();
            LogActivityHelper::addToLog('Deleted street ' . $itsName);

            alert()->success('You have successful deleted ' . $itsName . '.');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
    public function getStreets(Request $request)
    {
        $filteredStreets = Street::where(['status' => 1, 'sub_ward_id' => $request->subWardId])->orderBy('name')->get();
        $options = '';
        $options .= '<option value="">' . "--" . '</option>';
        foreach ($filteredStreets as $street) {
            $options .= '<option value="' . $street->id . '">' . $street->name . '</option>';
        }

        // $options = '';

        // foreach ($filteredWards as $ward) {
        //     $options .= '<option value="' . $ward->id . '">' . $ward->name . '</option>';
        // }

        return response()->json(['filteredStreets' => $options]);
    }
}
