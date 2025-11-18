<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZoneMemberPay;
use App\Exports\ZoneMemberExport;
use Illuminate\Support\Facades\DB;
use App\Exports\ZoneMemberFeeExport;

class ZoneMemberFeeReport extends Controller
{
    public function first()
    {
        $export = false;
        $zone = 'zone1';
        $name = 'Arsii';
        $reports = ZoneMemberPay::where('model', $zone)
            ->select('woreda', 'position', DB::raw('sum(amount) as total'))
            ->groupBy('position', 'woreda')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->zone = $name;
            $report->woreda = $report->woreda;
            $report->position = $report->position;
            $report->total = $report->total;
        }

        return view('report.zoneMemberFee', compact('reports', 'name', 'zone', 'export'));
    }
    public function fetch($zone)
    {
        $woredas = DB::table($zone)->select('woreda')->groupBy('woreda')->pluck('woreda');
        return response()->json($woredas);
    }
    public function index(Request $request)
    {
        $export = true;
        $zone = $request->zone;


        if ($zone == 'zone1') {
            $name = 'Arsii';
        } elseif ($zone == 'zone2') {
            $name = 'Arsii-Lixaa';
        } elseif ($zone == 'zone3') {
            $name = 'Baalee';
        } elseif ($zone == 'zone4') {
            $name = 'Baalee-Bahaa';
        } elseif ($zone == 'zone5') {
            $name = 'Booranaa';
        } elseif ($zone == 'zone6') {
            $name = 'Bunno- Baddalle';
        } elseif ($zone == 'zone7') {
            $name = 'Finfinnee';
        } elseif ($zone == 'zone8') {
            $name = 'Gujii';
        } elseif ($zone == 'zone9') {
            $name = 'Gujii-Lixaa';
        } elseif ($zone == 'zone10') {
            $name = 'Harargee-Bahaa';
        } elseif ($zone == 'zone11') {
            $name = 'Harargee-Lixaa';
        } elseif ($zone == 'zone12') {
            $name = 'Horroo-Guduruu-Wallaga';
        } elseif ($zone == 'zone13') {
            $name = 'Iluu-Abbaa-Booraa';
        } elseif ($zone == 'zone14') {
            $name = 'Jimmaa';
        } elseif ($zone == 'zone15') {
            $name = 'Qeellam-Wallaga';
        } elseif ($zone == 'zone16') {
            $name = 'Shawaa-Bahaa';
        } elseif ($zone == 'zone17') {
            $name = 'Shawaa-Kaabaa';
        } elseif ($zone == 'zone18') {
            $name = 'Shawaa-Kibbaaa-Lixaa';
        } elseif ($zone == 'zone19') {
            $name = 'Shawaa-Lixaa';
        } elseif ($zone == 'zone20') {
            $name = 'Wallaga-Bahaa';
        } elseif ($zone == 'zone21') {
            $name = 'Wallaga-Lixaa';
        }
        $woreda = $request->woreda;
        $month = $request->month;
        $year = $request->year;

        $reports = ZoneMemberPay::where('model', $zone)
            ->where('woreda', $woreda)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->select('woreda', 'position', DB::raw('sum(amount) as total'))
            ->groupBy('position', 'woreda')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->zone = $name;
            $report->woreda = $report->woreda;
            $report->position = $report->position;
            $report->date = $month . '-' . $year;
            $report->total = $report->total;
        }

        return view('report.zoneMemberFee', compact('reports', 'name', 'zone', 'woreda', 'month', 'year', 'export'));
    }

    public function export($zone, $woreda, $month, $year)
    {
        $date = date('d-m-y');
        if ($zone == 'zone1') {
            $name = 'Arsii';
        } elseif ($zone == 'zone2') {
            $name = 'Arsii-Lixaa';
        } elseif ($zone == 'zone3') {
            $name = 'Baalee';
        } elseif ($zone == 'zone4') {
            $name = 'Baalee-Bahaa';
        } elseif ($zone == 'zone5') {
            $name = 'Booranaa';
        } elseif ($zone == 'zone6') {
            $name = 'Bunno- Baddalle';
        } elseif ($zone == 'zone7') {
            $name = 'Finfinnee';
        } elseif ($zone == 'zone8') {
            $name = 'Gujii';
        } elseif ($zone == 'zone9') {
            $name = 'Gujii-Lixaa';
        } elseif ($zone == 'zone10') {
            $name = 'Harargee-Bahaa';
        } elseif ($zone == 'zone11') {
            $name = 'Harargee-Lixaa';
        } elseif ($zone == 'zone12') {
            $name = 'Horroo-Guduruu-Wallaga';
        } elseif ($zone == 'zone13') {
            $name = 'Iluu-Abbaa-Booraa';
        } elseif ($zone == 'zone14') {
            $name = 'Jimmaa';
        } elseif ($zone == 'zone15') {
            $name = 'Qeellam-Wallaga';
        } elseif ($zone == 'zone16') {
            $name = 'Shawaa-Bahaa';
        } elseif ($zone == 'zone17') {
            $name = 'Shawaa-Kaabaa';
        } elseif ($zone == 'zone18') {
            $name = 'Shawaa-Kibbaaa-Lixaa';
        } elseif ($zone == 'zone19') {
            $name = 'Shawaa-Lixaa';
        } elseif ($zone == 'zone20') {
            $name = 'Wallaga-Bahaa';
        } elseif ($zone == 'zone21') {
            $name = 'Wallaga-Lixaa';
        }

        $reports = ZoneMemberPay::where('model', $zone)
            ->where('woreda', $woreda)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->select('woreda', 'position', DB::raw('sum(amount) as total'))
            ->groupBy('position', 'woreda')
            ->get();

        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->zone = $name;
            $report->woreda = $report->woreda;
            $report->position = $report->position;
            $report->date = $month . '-' . $year;
            $report->total = $report->total;
        }



        return (new ZoneMemberFeeExport($reports))->download("ZoneMemberFeeReport" . $date . ".xlsx");
    }
}
