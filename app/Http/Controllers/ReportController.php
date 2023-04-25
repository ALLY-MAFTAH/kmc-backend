<?php

namespace App\Http\Controllers;

// use Carbon\Carbon;
use App\Models\Business;
use App\Models\Province;
use App\Models\Street;
use App\Models\SubWard;
use App\Models\Type;
use App\Models\Vehicle;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Jimmyjs\ReportGenerator\ReportMedia\CSVReport;
use Jimmyjs\ReportGenerator\ReportMedia\ExcelReport;
use Jimmyjs\ReportGenerator\ReportMedia\PdfReport;

class ReportController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        $subWards = SubWard::where('status', 1)->get();
        $wards = Ward::where('status', 1)->get();
        $provinces = Province::where('status', 1)->get();
        $streets = Street::where('status', 1)->get();
        return view('reports.index', compact('vehicles', 'provinces', 'wards', 'subWards', 'streets'));
    }

    public function businessReport(Request $request)
    {

        $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date, 'UTC')->setTimezone('Africa/Dar_es_salaam');
        $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date, 'UTC')->setTimezone('Africa/Dar_es_salaam');
        $sortBy = $request->sort_by;
        $groupBy = null;
        $orientation = $request->input('orientation');
        $provinceId = $request->input('province_id');
        $wardId = $request->input('ward_id');
        $subWardId = $request->input('sub_ward_id');
        $streetId = $request->input('street_id');

        if ($request->group_by == "type_id") {
            $groupBy = "Type";
        }
        if ($request->group_by == "province_id") {
            $groupBy = "Province";
        }
        if ($request->group_by == "ward_id") {
            $groupBy = "Ward";
        }
        if ($request->group_by == "sub_ward_id") {
            $groupBy = "Sub-Ward";
        }
        if ($request->group_by == "street_id") {
            $groupBy = "Street";
        }
        // dd($request->all());

        $title = "Businesses";
        $meta = [
            'Registered from' => Carbon::parse($fromDate)->format('D, d M Y') . ' to ' . Carbon::parse($toDate)->format('D, d M Y'),
            'Sorted By' => $sortBy
        ];

        try {
            $columns = [
                'Registered Date' => function ($result) {
                    return Carbon::parse($result->created_at)->format('d M, Y');
                },
                'Name' => 'name',
                'TIN' => 'tin',
                'NIDA' => 'nida',
                "PayerID" =>  'payerId',
                'Type' => function ($result) {
                    return $result->type->name;
                },
                'Phone' => 'mobile',
                'Email' => 'email',
                // "Address" => 'address',
                // "House No." => 'house_number',

            ];
            if ($streetId != null) {
                $businesses = Business::where(['street_id' => $streetId])->whereBetween('created_at', [$fromDate, $toDate])->orderBy($sortBy);
                $title = "Businesses in " . Street::find($streetId)->name;
                $columns['Street'] = function ($result) {
                    return $result->street->name;
                };
            } elseif ($subWardId != null) {
                $businesses = Business::where(['sub_ward_id' => $subWardId])->whereBetween('created_at', [$fromDate, $toDate])->orderBy($sortBy);
                $columns['Sub-Ward'] = function ($result) {
                    return $result->subWard->name;
                };
                $title = "Businesses in " . SubWard::find($subWardId)->name;
            } elseif ($wardId != null) {
                $businesses = Business::where(['ward_id' => $wardId])->whereBetween('created_at', [$fromDate, $toDate])->orderBy($sortBy);
                $title = "Businesses in " . Ward::find($wardId)->name;
                $columns['Ward'] = function ($result) {
                    return $result->ward->name;
                };
            } elseif ($provinceId != null) {
                $businesses = Business::where(['province_id' => $provinceId])->whereBetween('created_at', [$fromDate, $toDate])->orderBy($sortBy);
                $title = "Businesses in " . Province::find($provinceId)->name;
                $columns['Province'] = function ($result) {
                    return $result->province->name;
                };
                // dd($sortBy);
            } else {
                $businesses = Business::whereBetween('created_at', [$fromDate, $toDate])->orderBy($sortBy);
            }
            // dd($title);

            $reportInstance = new PdfReport();
            // $reportInstance = new ExcelReport();
            // $reportInstance = new CSVReport  ();
            if ($groupBy != null) {
                return $reportInstance->of($title, $meta, $businesses, $columns)
                    ->setOrientation($orientation)
                    ->editColumn('Registered Date', [])
                    ->groupBy($groupBy)
                    ->stream(); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
            } else {
                return $reportInstance->of($title, $meta, $businesses, $columns)
                    ->setOrientation($orientation)
                    ->editColumn('Registered Date', [])
                    ->stream(); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
