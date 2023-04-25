<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Owner;
use App\Models\Parking;
use App\Models\Sticker;
use App\Models\Payment;
use App\Models\Vehicle;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $parkings = Parking::orderBy('pln')->get();
        $vehicles = Vehicle::all();
        $stickers = Sticker::all();
        $owners = Owner::all();
        $drivers = Driver::all();
        $payments = Payment::all();

        // dd("d");
        return view('home', compact(
            'parkings',
            'vehicles',
            'stickers',
            'owners',
            'drivers',
            'payments',
        ));
    }
}
