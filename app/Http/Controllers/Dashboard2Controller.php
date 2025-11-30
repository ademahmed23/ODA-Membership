<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class Dashboard2Controller extends Controller{

    public function index(){
        $urgent = Announcement::latest()->first();

            $citys = [
        'city1s' => 'Adaamaa',
        'city2s' => 'Amboo',
        'city3s' => 'Asallaa',
        'city4s' => 'Baatuu',
        'city5s' => 'Bishoooftuu',
        'city6s' => 'Burraayyuu',
        'city7s' => 'Dukaam',
        'city8s' => 'Finfinnee',
        'city9s' => 'Galaan',
        'city10s' => 'Holotaa',
        'city11s' => 'Jimmaa',
        'city12s' => 'Laga Xaafoo',
        'city13s' => 'Mojoo',
        'city14s' => 'Naqamtee',
        'city15s' => 'Roobee',
        'city16s' => 'Shaashamannee',
        'city17s' => 'Sabbataa',
        'city18s' => 'sulultaa',
        'city19s' => 'Walisoo',
    ];
    

      $cityCounts = [];

    foreach ($citys as $table => $name) {
        $cityCounts[] = [
            'city' => $name,
            'members' => \DB::table($table)->count()
        ];
    }
    
        return view('dashboard2', [ 'cityCounts' => $cityCounts],compact('cityCounts','urgent'));
    }

}