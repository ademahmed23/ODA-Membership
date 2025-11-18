<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegionMemberPay;
use App\Exports\RegionMemberExport;
use Illuminate\Support\Facades\DB;
use App\Exports\RegionMemberFeeExport;
use App\Models\Region;

class RegionMemberFeeReport extends Controller
{
    public function first()
    {
        $export = false;
        $region = 'Tigray';
        $regions = Region::all();
        $reports = RegionMemberPay::where('region', $region)
            ->select('position', DB::raw('sum(amount) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->region = $region;
            $report->position = $report->position;
            $report->total = $report->total;
        }

        return view('report.regionMemberFee', compact('reports', 'region', 'export', 'regions'));
    }
    public function fetch($region)
    {
        $woredas = DB::table($region)->select('woreda')->groupBy('woreda')->pluck('woreda');
        return response()->json($woredas);
    }
    public function index(Request $request)
    {
        $regions = Region::all();

        $export = true;
        $region = $request->region;

        $month = $request->month;
        $year = $request->year;

        $reports = RegionMemberPay::where('region', $region)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->select('position', DB::raw('sum(amount) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->region = $region;
            $report->position = $report->position;
            $report->date = $month . '-' . $year;
            $report->total = $report->total;
        }

        return view('report.regionMemberFee', compact('reports', 'region', 'month', 'year', 'export', 'regions'));
    }

    public function export($region, $month, $year)
    {
        $date = date('d-m-y');

        $reports = RegionMemberPay::where('model', $region)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->select('position', DB::raw('sum(amount) as total'))
            ->groupBy('position')
            ->get();

        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->region = $region;
            $report->position = $report->position;
            $report->date = $month . '-' . $year;
            $report->total = $report->total;
        }



        return (new RegionMemberFeeExport($reports))->download("RegionMemberFeeReport" . $date . ".xlsx");
    }
}
