<?php

namespace App\Http\Controllers;

use App\Models\Regional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\RegionMemberExport;

class RegionMemberReport extends Controller
{
    public function first()
    {
        $reports =
            Regional::select('position', 'region', DB::raw('count(*) as total'))
            ->groupBy('position', 'region')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->position = $report->position;
            $report->total = $report->total;
        }
        $region = "Region";
        return view('report.regionMember', compact('region', 'reports'));
    }
    public function index(Request $request)
    {
        $region = $request->region;

        // $reports = DB::table($region)
        //     ->select('position', DB::raw('count(*) as total'))
        //     ->groupBy('position')
        //     ->get();

        $reports = Regional::where('region', $region)->select('position', DB::raw('count(*) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->region = $region;
            $report->position = $report->position;
            $report->total = $report->total;
        }

        return view('report.regionMember', compact('reports', 'region'));
    }

    public function export($region)
    {
        $date = date('d-m-y');



        $reports = Regional::where('region', $region)->select('position', DB::raw('count(*) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->region = $region;
            $report->position = $report->position;
            $report->total = $report->total;
        }



        return (new RegionMemberExport($reports))->download("RegionalMemberReport" . $date . ".xlsx");
    }
}
