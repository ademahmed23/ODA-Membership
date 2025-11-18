<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbroadMemberPay;
use App\Exports\AbroadMemberExport;
use Illuminate\Support\Facades\DB;
use App\Exports\AbroadMemberFeeExport;

class AbroadMemberFeeReport extends Controller
{
    public function first()
    {
        $export = false;
        $country = 'France';
        $reports = AbroadMemberPay::where('country', $country)
            ->select('position', DB::raw('sum(amount) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->country = $country;
            $report->position = $report->position;
            $report->total = $report->total;
        }

        return view('report.abroadMemberFee', compact('reports', 'country', 'export'));
    }
    public function fetch($abroad)
    {
        $woredas = DB::table($abroad)->select('woreda')->groupBy('woreda')->pluck('woreda');
        return response()->json($woredas);
    }
    public function index(Request $request)
    {
        $export = true;
        $country = $request->country;

        $month = $request->month;
        $year = $request->year;

        $reports = AbroadMemberPay::where('country', $country)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->select('position', DB::raw('sum(amount) as total'))
            ->groupBy('position')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->country = $country;
            $report->position = $report->position;
            $report->date = $month . '-' . $year;
            $report->total = $report->total;
        }

        return view('report.abroadMemberFee', compact('reports', 'country', 'month', 'year', 'export'));
    }

    public function export($country, $month, $year)
    {
        $date = date('d-m-y');

        $reports = AbroadMemberPay::where('country', $country)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->select('position', DB::raw('sum(amount) as total'))
            ->groupBy('position')
            ->get();

        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->country = $country;
            $report->position = $report->position;
            $report->date = $month . '-' . $year;
            $report->total = $report->total;
        }



        return (new AbroadMemberFeeExport($reports))->download("AbroadMemberFeeReport" . $date . ".xlsx");
    }
}
