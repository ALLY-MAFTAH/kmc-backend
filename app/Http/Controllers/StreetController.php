<?php

namespace App\Http\Controllers;

use App\Models\Street;
use Illuminate\Http\Request;

class StreetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->all());
        try {
            $streets = Street::where(['status' => true])->get();

            return response()->json(['streets' => $streets, 'status' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'status' => 0], 404);
        }
    }
}
