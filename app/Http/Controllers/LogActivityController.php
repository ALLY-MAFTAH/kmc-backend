<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Business;
use App\Models\LogActivity;
use App\Models\Source;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = LogActivityHelper::logActivityLists();
        $businesses = Business::orderBy('tin')->get();

        return view('logs.index', compact('logs','businesses'));
    }
}
