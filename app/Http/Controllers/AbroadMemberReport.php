<?php

namespace App\Http\Controllers;

use App\Models\Abroad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\AbroadMemberExport;
use App\Exports\RegionMemberExport;

class AbroadMemberReport extends Controller
{
    public function first()
    {

        $countries = Abroad::select('country')->groupBy('country')->pluck('country');

        return view('report.regionMember', compact('countries'));
    }
    public function index(Request $request)
    {
        $countries = Abroad::select('country')->groupBy('country')->pluck('country');
        $country = $request->country;

        // $reports = DB::table($region)
        //     ->select('position', DB::raw('count(*) as total'))
        //     ->groupBy('position')
        //     ->get();

        $reports = Abroad::where('country', $country)->select('position', DB::raw('count(*) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->country = $country;
            $report->position = $report->position;
            $report->total = $report->total;
        }

        return view('report.abroadMember', compact('reports', 'country', 'countries'));
    }

    public function export($country)
    {
        $date = date('d-m-y');



        $reports = Abroad::where('country', $country)->select('position', DB::raw('count(*) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->country = $country;
            $report->position = $report->position;
            $report->total = $report->total;
        }



        return (new AbroadMemberExport($reports))->download("AbroadMemberReport" . $date . ".xlsx");
    }
}
