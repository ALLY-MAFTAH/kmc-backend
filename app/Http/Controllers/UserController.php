<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Vehicle;
use App\Models\Role;
use App\Models\Source;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::where('status', 1)->get();

        $users = User::all();
        $vehicles = Vehicle::all();

        return view('users.index', compact('users', 'roles', 'vehicles'));
    }
    public function showUser(Request $request, User $user)
    {
        $roles = Role::where('status', 1)->get();

        return view('users.show', compact('user', 'roles'));
    }
    public function postUser(Request $request)
    {
        try {
            $attributes = $this->validate($request, [
                'name' => 'required',
                'email' => 'required |unique:users,email,except,id',
                'role_id' => 'required',
            ]);

            $attributes['password'] = bcrypt('12312345');
            $attributes['status'] = true;

            $user = User::create($attributes);

            $role = Role::find($request->role_id);
            $role->users()->save($user);
            LogActivityHelper::addToLog('Added new user: ' . $user->name);

            alert()->success('You have successful added new user');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return redirect()->back();
    }

    public function putUser(Request $request, User $user)
    {
        try {
            session()->flash('user_id', $user->id);
            $attributes = $this->validateWithBag('update', $request, [
                'name' => 'required',
                'email' => ['sometimes', Rule::unique('users')->ignore($user->id)->whereNull('deleted_at')],
                'role_id' => ['sometimes', 'exists:roles,id'],
            ]);

            $user->update($attributes);
            LogActivityHelper::addToLog('Updated user: ' . $user->name);

            alert()->success('You have successful edited user');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }

    public function toggleStatus(Request $request, User $user)
    {
        try {
            $attributes = $this->validate($request, [
                'status' => ['required', 'boolean'],
            ]);

            $user->update($attributes);
            LogActivityHelper::addToLog('Switched user ' . $user->name . ' status ');

            alert()->success('You have successfully updated user status');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
    public function deleteUser(User $user)
    {
        try {
            $itsName = $user->name;
            $user->delete();
            LogActivityHelper::addToLog('Deleted user: ' . $itsName);

            alert()->success('You have successful deleted ' . $itsName . '.');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
        }
        return back();
    }
}
