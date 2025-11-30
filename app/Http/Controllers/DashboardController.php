<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Zone1;
use App\Models\Announcement;
use Illuminate\Http\Request;

class DashboardController
{
    public function __invoke(Request $request)
    {
$zones = [];
$city = [];

for ($i = 1; $i <= 21; $i++) {
    $zones[] = "zone{$i}s";
}
for($a = 1; $a <=19; $a++){
    $city[] = "city{$a}s";
}
$roles = \DB::table('roles')->count();
$officers = \DB::table('w_officers')->count();

$all = collect($zones)->sum(fn($z) => \DB::table($z)->count());
$allcity = collect($city)->sum(fn($c) => \DB::table($c)->count());
$woreda = \DB::table('woreda')->count();


// Optional: return or dd
// dd($total);

        $news = News::count();
        $count = Zone1::count();
        $announcement = Announcement::count();
        $members = Zone1::count();



    $zones = [
        'zone1s' => 'Arsii',
        'zone2s' => 'A/Lixaa',
        'zone3s' => 'Baalee',
        'zone4s' => 'B/Bahaa',
        'zone5s' => 'Booranaa',
        'zone6s' => 'B/Baddalle',
        'zone7s' => 'Finfinnee',
        'zone8s' => 'Gujii',
        'zone9s' => 'G/Lixaa',
        'zone10s' => 'H/Bahaa',
        'zone11s' => 'H/Lixaa',
        'zone12s' => 'H/G/Wallaga',
        'zone13s' => 'I/A/Booraa',
        'zone14s' => 'Jimmaa',
        'zone15s' => 'Q/Wallaga',
        'zone16s' => 'Sh/Bahaa',
        'zone17s' => 'Sh/Kaabaa',
        'zone18s' => 'Sh/K/Lixaa',
        'zone19s' => 'Sh/Lixaa',
        'zone20s' => 'W/Bahaa',
        'zone21s' => 'W/Lixaa'
    ];
    

      $zoneCounts = [];

    foreach ($zones as $table => $name) {
        $zoneCounts[] = [
            'zone' => $name,
            'members' => \DB::table($table)->count()
        ];
    }






 $orgs = [
        'arsii' => 'Arsii',
        'arsii_lixaa' => 'A/Lixaa',
        'baalee' => 'Baalee',
        'b_bahaa' => 'B/Bahaa',
        'booranaa' => 'Booranaa',
        'b_baddalle' => 'B/Baddalle',
        'finfinnee' => 'Finfinnee',
        'gujii' => 'Gujii',
        'g_lixaa' => 'G/Lixaa',
        'h_bahaa' => 'H/Bahaa',
        'h_lixaa' => 'H/Lixaa',
        'h_g_wallaga' => 'H/G/Wallaga',
        'i_a_booraa' => 'I/A/Booraa',
        'jimmaa' => 'Jimmaa',
        'q_wallaga' => 'Q/Wallaga',
        'sh_bahaa' => 'Sh/Bahaa',
        'sh_kaabaa' => 'Sh/Kaabaa',
        'sh_k_lixaa' => 'Sh/K/Lixaa',
        'sh_lixaa' => 'Sh/Lixaa',
        'wahaa' => 'W/Bahaa',
        'w_lixaa' => 'W/Lixaa'
    ];

   $orgacount = [];

    foreach ($orgs as $table => $name) {
        $orgacount[] = [
            'ahmed' => $name,
            'adem' => \DB::table($table)->count()
        ];
    }






$zonesposition =[
          'zone1s','zone2s','zone3s','zone4s','zone5s',
        'zone6s','zone7s','zone8s','zone9s','zone10s',
        'zone11s','zone12s','zone13s','zone14s','zone15s',
        'zone16s','zone17s','zone18s','zone19s','zone20s','zone21s'
    ];

     $positions = [
        'Qonnaan Bulaa',
        'Jiraata Magaala',
        'Daldala-A',
        'Daldala-B',
        'Daldala-C',
        'Hojjeta Motummaa'
    ];

    // Initialize position counters
    $positionCounts = array_fill_keys($positions, 0);

    foreach ($zonesposition as $zone) {
        foreach ($positions as $pos) {
            $count = \DB::table($zone)
                ->where('position', $pos)
                ->count();


            $positionCounts[$pos] += $count;
        }
    }

$zoneCounter = \DB::table('w_officers')
    ->select('zone', \DB::raw('COUNT(name) AS total'))
    ->groupBy('zone')
    ->pluck('total', 'zone')      // returns ["Sh/Kaaabaa" => 8]
    ->toArray();  
    // dd($zoneCounter);
                // convert collection → array





        return view('dashboard',  compact('news', 'announcement', 'members','count','all','woreda','allcity','roles','officers','zoneCounts','orgacount','positionCounts','zonesposition','zoneCounter'),
        ['positionCounts' => $positionCounts],['zoneCounts' => $zoneCounts],['zoneCounter' => $zoneCounter]);
    }


    public function index2(){
        return view('dashboard2');
    }
}
