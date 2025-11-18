<?php

namespace App\Http\Controllers;

use App\Exports\ZoneMemberExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZoneMemberReport extends Controller
{
    public function first()
    {
        $export =  false;
        $zone = 'zone1s';
        $name = 'Arsii';
        $reports = DB::table($zone)
            ->select('woreda', 'position','first_name','middle_name', DB::raw('count(*) as total'))
            ->groupBy('position', 'woreda','first_name','middle_name')
            ->paginate(10);
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->zone = $name;
            $report->woreda = $report->woreda;
            $report->position = $report->position;
            $report->total = $report->total;
        }

        return view('report.zoneMember', compact('reports', 'name', 'zone', 'export'),['paginate'=>$reports]);
    }
    public function fetch($zone)
    {
        $woredas = DB::table($zone)->select('woreda')->groupBy('woreda')->pluck('woreda');
        return response()->json($woredas);
    }
    public function index(Request $request)
    {
        $zone = $request->zone;
        $export = true;


        if ($zone == 'zone1s') {
            $name = 'Arsii';
        } elseif ($zone == 'zone2s') {
            $name = 'Arsii-Lixaa';
        } elseif ($zone == 'zone3s') {
            $name = 'Baalee';
        } elseif ($zone == 'zone4s') {
            $name = 'Baalee-Bahaa';
        } elseif ($zone == 'zone5s') {
            $name = 'Booranaa';
        } elseif ($zone == 'zone6s') {
            $name = 'Bunno- Baddalle';
        } elseif ($zone == 'zone7s') {
            $name = 'Finfinnee';
        } elseif ($zone == 'zone8s') {
            $name = 'Gujii';
        } elseif ($zone == 'zone9s') {
            $name = 'Gujii-Lixaa';
        } elseif ($zone == 'zone10s') {
            $name = 'Harargee-Bahaa';
        } elseif ($zone == 'zone11s') {
            $name = 'Harargee-Lixaa';
        } elseif ($zone == 'zone12s') {
            $name = 'Horroo-Guduruu-Wallaga';
        } elseif ($zone == 'zone13s') {
            $name = 'Iluu-Abbaa-Booraa';
        } elseif ($zone == 'zone14s') {
            $name = 'Jimmaa';
        } elseif ($zone == 'zone15s') {
            $name = 'Qeellam-Wallaga';
        } elseif ($zone == 'zone16s') {
            $name = 'Shawaa-Bahaa';
        } elseif ($zone == 'zone17s') {
            $name = 'Shawaa-Kaabaa';
        } elseif ($zone == 'zone18s') {
            $name = 'Shawaa-Kibbaaa-Lixaa';
        } elseif ($zone == 'zone19s') {
            $name = 'Shawaa-Lixaa';
        } elseif ($zone == 'zone20s') {
            $name = 'Wallaga-Bahaa';
        } elseif ($zone == 'zone21s') {
            $name = 'Wallaga-Lixaa';
        }
        $woreda = $request->woreda;

        $reports = DB::table($zone)
            ->where('woreda', $woreda)
            ->select('woreda', 'position', DB::raw('count(*) as total'))
            ->groupBy('position', 'woreda')
            ->paginate(10);
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->zone = $name;
            $report->woreda = $report->woreda;
            $report->position = $report->position;
            $report->total = $report->total;
        }

        return view('report.zoneMember', compact('reports', 'name', 'zone', 'woreda', 'export'),['paginate'=>$reports]);
    }

    public function export($zone, $woreda)
    {
        $date = date('d-m-y');

        if ($zone == 'zone1s') {
            $name = 'Arsii';
        } elseif ($zone == 'zone2s') {
            $name = 'Arsii-Lixaa';
        } elseif ($zone == 'zone3s') {
            $name = 'Baalee';
        } elseif ($zone == 'zone4s') {
            $name = 'Baalee-Bahaa';
        } elseif ($zone == 'zone5s') {
            $name = 'Booranaa';
        } elseif ($zone == 'zone6s') {
            $name = 'Bunno- Baddalle';
        } elseif ($zone == 'zone7s') {
            $name = 'Finfinnee';
        } elseif ($zone == 'zone8s') {
            $name = 'Gujii';
        } elseif ($zone == 'zone9s') {
            $name = 'Gujii-Lixaa';
        } elseif ($zone == 'zone10s') {
            $name = 'Harargee-Bahaa';
        } elseif ($zone == 'zone11s') {
            $name = 'Harargee-Lixaa';
        } elseif ($zone == 'zone12s') {
            $name = 'Horroo-Guduruu-Wallaga';
        } elseif ($zone == 'zone13s') {
            $name = 'Iluu-Abbaa-Booraa';
        } elseif ($zone == 'zone14s') {
            $name = 'Jimmaa';
        } elseif ($zone == 'zone15s') {
            $name = 'Qeellam-Wallaga';
        } elseif ($zone == 'zone16s') {
            $name = 'Shawaa-Bahaa';
        } elseif ($zone == 'zone17s') {
            $name = 'Shawaa-Kaabaa';
        } elseif ($zone == 'zone18s') {
            $name = 'Shawaa-Kibbaaa-Lixaa';
        } elseif ($zone == 'zone19s') {
            $name = 'Shawaa-Lixaa';
        } elseif ($zone == 'zone20s') {
            $name = 'Wallaga-Bahaa';
        } elseif ($zone == 'zone21s') {
            $name = 'Wallaga-Lixaa';
        }

        $reports =
            DB::table($zone)
            ->where('woreda', $woreda)
            ->select('woreda', 'position', DB::raw('count(*) as total'))
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



        return (new ZoneMemberExport($reports))->download("ZoneMemberReport" . $date . ".xlsx");
    }
}
