<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function loginApi(Request $request)
    {
        // $token =  Str::random(60);
        try {

            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if (Auth::attempt($credentials)) {
                $authUser = Auth::user();
                $user = User::find($authUser->id);
                $token = $user->createToken('auth_token');
                // dd($token);
                return response()->json([
                    'user' => $user,
                    'access_token' => $token->accessToken,
                    'token_type' => 'Bearer',
                ]);
            }

            return response()->json([
                'error' =>  'Email or Password Not Correct',
            ], 401);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], 401);
        }
    }
}
