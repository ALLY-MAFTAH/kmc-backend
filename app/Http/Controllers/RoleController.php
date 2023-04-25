<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Vehicle;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $vehicles = Vehicle::all();
        return view('roles.index', compact('roles', 'vehicles'));
    }
    public function showRole(Request $request, Role $role)
    {
        $vehicles = Vehicle::all();
        return view('roles.show', compact('role', 'vehicles'));
    }
    public function postRole(Request $request)
    {
        try {

            $attributes = $this->validate($request, [
                'name' => 'required |unique:roles,name,except,id',
                'description' => 'required',
            ]);

            $attributes['status'] = true;
            $role = Role::create($attributes);
            LogActivityHelper::addToLog('Added role ' . $role->name);

            alert()->success('You have successful added  new role');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return Redirect::back();
    }
    public function putRole(Request $request, Role $role)
    {
        try {
            $attributes = $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
            ]);

            $role->update($attributes);
            LogActivityHelper::addToLog('Updated role ' . $role->name);

            alert()->success('You have successful edited role');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return redirect()->back();
    }
    public function toggleStatus(Request $request, Role $role)
    {
        try {
            $attributes = $this->validate($request, [
                'status' => ['required', 'boolean'],
            ]);

            $role->update($attributes);
            LogActivityHelper::addToLog('Switched role ' . $role->name . ' status ');

            alert()->success('You have successfully updated role status');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
    public function deleteRole(Request $request, Role $role)
    {
        try {
            $itsName = $role->name;
            $role->delete();
            LogActivityHelper::addToLog('Deleted role ' . $itsName);

            alert()->success('You have successful deleted ' . $itsName . '.');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
}
