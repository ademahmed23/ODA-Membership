<?php

namespace App\Http\Controllers;

use App\Exports\CityMemberExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityMemberReport extends Controller
{
    public function first()
    {
        $city = 'city1s';
        $name = 'B-M-Adaamaa';
        $reports = DB::table($city)
            ->select('position', DB::raw('count(*) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->city = $name;
            $report->position = $report->position;
            $report->total = $report->total;
        }

        return view('report.cityMember', compact('reports', 'name', 'city'));
    }
    public function index(Request $request)
    {
        $city = $request->city;
        if ($city == 'city1s') {
            $name = 'B-M-Adaamaa';
        } elseif ($city == 'city2s') {
            $name = 'B-M-Amboo';
        } elseif ($city == 'city3s') {
            $name = 'B-M-Asallaa';
        } elseif ($city == 'city4s') {
            $name = 'B-M-Baatuu';
        } elseif ($city == 'city5s') {
            $name = 'B-M-Bishooftuu';
        } elseif ($city == 'city6s') {
            $name = 'B-M-Buraayyuu';
        } elseif ($city == 'city7s') {
            $name = 'B-M-Dukam';
        } elseif ($city == 'city8s') {
            $name = 'B-M-Finfinnee';
        } elseif ($city == 'city9s') {
            $name = 'B-M-Galaan';
        } elseif ($city == 'city10s') {
            $name = 'B-M-Hoolotaa';
        } elseif ($city == 'city11s') {
            $name = 'B-M-Jimmaa';
        } elseif ($city == 'city12s') {
            $name = 'B-M-L_Xaafoo';
        } elseif ($city == 'city13s') {
            $name = 'B-M-Mojoo';
        } elseif ($city == 'city14s') {
            $name = 'B-M-Naqamtee';
        } elseif ($city == 'city15s') {
            $name = 'B-M-Roobee';
        } elseif ($city == 'city16s') {
            $name = 'B-M-Shaashaamannee';
        } elseif ($city == 'city17s') {
            $name = 'B-M-Sabbaataa';
        } elseif ($city == 'city18s') {
            $name = 'B-M-Sulultaa';
        } elseif ($city == 'city19s') {
            $name = 'B-M-Walisoo';
        }

        $reports = DB::table($city)
            ->select('position', DB::raw('count(*) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->city = $name;
            $report->position = $report->position;
            $report->total = $report->total;
        }

        return view('report.cityMember', compact('reports', 'name', 'city'));
    }

    public function export($city)
    {
        $date = date('d-m-y');

        if ($city == 'city1s') {
            $name = 'B-M-Adaamaa';
        } elseif ($city == 'city2s') {
            $name = 'B-M-Amboo';
        } elseif ($city == 'city3s') {
            $name = 'B-M-Asallaa';
        } elseif ($city == 'city4s') {
            $name = 'B-M-Baatuu';
        } elseif ($city == 'city5s') {
            $name = 'B-M-Bishooftuu';
        } elseif ($city == 'city6s') {
            $name = 'B-M-Buraayyuu';
        } elseif ($city == 'city7s') {
            $name = 'B-M-Dukam';
        } elseif ($city == 'city8s') {
            $name = 'B-M-Finfinnee';
        } elseif ($city == 'city9s') {
            $name = 'B-M-Galaan';
        } elseif ($city == 'city10s') {
            $name = 'B-M-Hoolotaa';
        } elseif ($city == 'city11s') {
            $name = 'B-M-Jimmaa';
        } elseif ($city == 'city12s') {
            $name = 'B-M-L_Xaafoo';
        } elseif ($city == 'city13s') {
            $name = 'B-M-Mojoo';
        } elseif ($city == 'city14s') {
            $name = 'B-M-Naqamtee';
        } elseif ($city == 'city15s') {
            $name = 'B-M-Roobee';
        } elseif ($city == 'city16s') {
            $name = 'B-M-Shaashaamannee';
        } elseif ($city == 'city17s') {
            $name = 'B-M-Sabbaataa';
        } elseif ($city == 'city18s') {
            $name = 'B-M-Sulultaa';
        } elseif ($city == 'city19s') {
            $name = 'B-M-Walisoo';
        }

        $reports =
            DB::table($city)
            ->select('position', DB::raw('count(*) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->city = $name;
            $report->position = $report->position;
            $report->total = $report->total;
        }



        return (new CityMemberExport($reports))->download("CityMemberReport" . $date . ".xlsx");
    }
}
