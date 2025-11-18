<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CityMemberPay;
use App\Exports\CityMemberExport;
use Illuminate\Support\Facades\DB;
use App\Exports\CityMemberFeeExport;

class CityMemberFeeReport extends Controller
{
    public function first()
    {
        $export = false;
        $city = 'city1';
        $name = 'B-M-Adaamaa';
        $reports = CityMemberPay::where('model', $city)
            ->select('position', DB::raw('sum(amount) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->city = $name;
            $report->position = $report->position;
            $report->total = $report->total;
        }

        return view('report.cityMemberFee', compact('reports', 'name', 'city', 'export'));
    }

    public function index(Request $request)
    {
        $export = true;
        $city = $request->city;

        if ($city == 'city1') {
            $name = 'B-M-Adaamaa';
        } elseif ($city == 'city2') {
            $name = 'B-M-Amboo';
        } elseif ($city == 'city3') {
            $name = 'B-M-Asallaa';
        } elseif ($city == 'city4') {
            $name = 'B-M-Baatuu';
        } elseif ($city == 'city5') {
            $name = 'B-M-Bishooftuu';
        } elseif ($city == 'city6') {
            $name = 'B-M-Buraayyuu';
        } elseif ($city == 'city7') {
            $name = 'B-M-Dukam';
        } elseif ($city == 'city8') {
            $name = 'B-M-Finfinnee';
        } elseif ($city == 'city9') {
            $name = 'B-M-Galaan';
        } elseif ($city == 'city10') {
            $name = 'B-M-Hoolotaa';
        } elseif ($city == 'city11') {
            $name = 'B-M-Jimmaa';
        } elseif ($city == 'city12') {
            $name = 'B-M-L_Xaafoo';
        } elseif ($city == 'city13') {
            $name = 'B-M-Mojoo';
        } elseif ($city == 'city14') {
            $name = 'B-M-Naqamtee';
        } elseif ($city == 'city15') {
            $name = 'B-M-Roobee';
        } elseif ($city == 'city16') {
            $name = 'B-M-Shaashaamannee';
        } elseif ($city == 'city17') {
            $name = 'B-M-Sabbaataa';
        } elseif ($city == 'city18') {
            $name = 'B-M-Sulultaa';
        } elseif ($city == 'city19') {
            $name = 'B-M-Walisoo';
        }
        $month = $request->month;
        $year = $request->year;

        $reports = CityMemberPay::where('model', $city)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->select('position', DB::raw('sum(amount) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->city = $name;
            $report->position = $report->position;
            $report->date = $month . '-' . $year;
            $report->total = $report->total;
        }

        return view('report.cityMemberFee', compact('reports', 'name', 'city', 'month', 'year', 'export'));
    }

    public function export($city, $month, $year)
    {
        $date = date('d-m-y');
        if ($city == 'city1') {
            $name = 'B-M-Adaamaa';
        } elseif ($city == 'city2') {
            $name = 'B-M-Amboo';
        } elseif ($city == 'city3') {
            $name = 'B-M-Asallaa';
        } elseif ($city == 'city4') {
            $name = 'B-M-Baatuu';
        } elseif ($city == 'city5') {
            $name = 'B-M-Bishooftuu';
        } elseif ($city == 'city6') {
            $name = 'B-M-Buraayyuu';
        } elseif ($city == 'city7') {
            $name = 'B-M-Dukam';
        } elseif ($city == 'city8') {
            $name = 'B-M-Finfinnee';
        } elseif ($city == 'city9') {
            $name = 'B-M-Galaan';
        } elseif ($city == 'city10') {
            $name = 'B-M-Hoolotaa';
        } elseif ($city == 'city11') {
            $name = 'B-M-Jimmaa';
        } elseif ($city == 'city12') {
            $name = 'B-M-L_Xaafoo';
        } elseif ($city == 'city13') {
            $name = 'B-M-Mojoo';
        } elseif ($city == 'city14') {
            $name = 'B-M-Naqamtee';
        } elseif ($city == 'city15') {
            $name = 'B-M-Roobee';
        } elseif ($city == 'city16') {
            $name = 'B-M-Shaashaamannee';
        } elseif ($city == 'city17') {
            $name = 'B-M-Sabbaataa';
        } elseif ($city == 'city18') {
            $name = 'B-M-Sulultaa';
        } elseif ($city == 'city19') {
            $name = 'B-M-Walisoo';
        }

        $reports = CityMemberPay::where('model', $city)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->select('position', DB::raw('sum(amount) as total'))
            ->groupBy('position')
            ->get();

        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->city = $name;
            $report->position = $report->position;
            $report->date = $month . '-' . $year;
            $report->total = $report->total;
        }



        return (new CityMemberFeeExport($reports))->download("CityMemberFeeReport" . $date . ".xlsx");
    }
}
