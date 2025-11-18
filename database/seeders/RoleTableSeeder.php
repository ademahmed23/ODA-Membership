<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Zone 1',
            'Zone 2',
            'Zone 3',
            'Zone 4',
            'Zone 5',
            'Zone 6',
            'Zone 7',
            'Zone 8',
            'Zone 9',
            'Zone 10',
            'Zone 11',
            'Zone 12',
            'Zone 13',
            'Zone 14',
            'Zone 15',
            'Zone 16',
            'Zone 17',
            'Zone 18',
            'Zone 19',
            'Zone 20',
            'Zone 21',
            'City 1',
            'City 2',
            'City 3',
            'City 4',
            'City 5',
            'City 6',
            'City 7',
            'City 8',
            'City 9',
            'City 10',
            'City 11',
            'City 12',
            'City 13',
            'City 14',
            'City 15',
            'City 16',
            'City 17',
            'City 18',
            'City 19',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role, 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
