<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run()
    {
        Region::truncate();

        $regions = [
            ['name' => 'Tigray'],
            ['name' => 'Afar'],
            ['name' => 'Amhara'],
            ['name' => 'Benishangul-Gumuz'],
            ['name' => 'Dire Dawa'],
            ['name' => 'Gambela'],
            ['name' => 'Harari'],
            ['name' => 'Somali'],
            ['name' => 'SNNP'],
            ['name' => 'Addis Ababa'],
            ['name' => 'Sidama']
        ];

        foreach ($regions as $key => $value) {
            Region::create($value);
        }
    }
}
