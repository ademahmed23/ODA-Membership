<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.

     *

     * @return void
     */
    public function run()
    {
        $permissions = [

            'role-list',

            'role-create',

            'role-edit',

            'role-delete',

            'user-list',

            'user-create',

            'user-edit',

            'user-delete',

            'student-list',

            'student-create',

            'student-edit',

            'student-delete',

            'news-list',

            'news-create',

            'news-edit',

            'news-delete',

            'announcement-list',

            'announcement-create',

            'announcement-edit',

            'announcement-delete',

            'honorable-list',

            'honorable-create',

            'honorable-edit',

            'honorable-delete',

            'zone1-list',

            'zone1-create',

            'zone1-edit',

            'zone1-delete',

            'zone2-list',

            'zone2-create',

            'zone2-edit',

            'zone2-delete',

            'zone3-list',

            'zone3-create',

            'zone3-edit',

            'zone3-delete',

            'zone4-list',

            'zone4-create',

            'zone4-edit',

            'zone4-delete',

            'zone5-list',

            'zone5-create',

            'zone5-edit',

            'zone5-delete',

            'zone6-list',

            'zone6-create',

            'zone6-edit',

            'zone6-delete',

            'zone7-list',

            'zone7-create',

            'zone7-edit',

            'zone7-delete',

            'zone8-list',

            'zone8-create',

            'zone8-edit',

            'zone8-delete',

            'zone9-list',

            'zone9-create',

            'zone9-edit',

            'zone9-delete',

            'zone10-list',

            'zone10-create',

            'zone10-edit',

            'zone10-delete',

            'zone11-list',

            'zone11-create',

            'zone11-edit',

            'zone11-delete',

            'zone12-list',

            'zone12-create',

            'zone12-edit',

            'zone12-delete',

            'zone13-list',

            'zone13-create',

            'zone13-edit',

            'zone13-delete',

            'zone14-list',

            'zone14-create',

            'zone14-edit',

            'zone14-delete',

            'zone15-list',

            'zone15-create',

            'zone15-edit',

            'zone15-delete',

            'zone16-list',

            'zone16-create',

            'zone16-edit',

            'zone16-delete',

            'zone17-list',

            'zone17-create',

            'zone17-edit',

            'zone17-delete',

            'zone18-list',

            'zone18-create',

            'zone18-edit',

            'zone18-delete',

            'zone19-list',

            'zone19-create',

            'zone19-edit',

            'zone19-delete',

            'zone20-list',

            'zone20-create',

            'zone20-edit',

            'zone20-delete',

            'zone21-list',

            'zone21-create',

            'zone21-edit',

            'zone21-delete',

            'city1-list',

            'city1-create',

            'city1-edit',

            'city1-delete',

            'city2-list',

            'city2-create',

            'city2-edit',

            'city2-delete',

            'city3-list',

            'city3-create',

            'city3-edit',

            'city3-delete',

            'city4-list',

            'city4-create',

            'city4-edit',

            'city4-delete',

            'city5-list',

            'city5-create',

            'city5-edit',

            'city5-delete',

            'city6-list',

            'city6-create',

            'city6-edit',

            'city6-delete',

            'city7-list',

            'city7-create',

            'city7-edit',

            'city7-delete',

            'city8-list',

            'city8-create',

            'city8-edit',

            'city8-delete',

            'city9-list',

            'city9-create',

            'city9-edit',

            'city9-delete',

            'city10-list',

            'city10-create',

            'city10-edit',

            'city10-delete',

            'city11-list',

            'city11-create',

            'city11-edit',

            'city11-delete',

            'city12-list',

            'city12-create',

            'city12-edit',

            'city12-delete',

            'city13-list',

            'city13-create',

            'city13-edit',

            'city13-delete',

            'city14-list',

            'city14-create',

            'city14-edit',

            'city14-delete',

            'city15-list',

            'city15-create',

            'city15-edit',

            'city15-delete',

            'city16-list',

            'city16-create',

            'city16-edit',

            'city16-delete',

            'city17-list',

            'city17-create',

            'city17-edit',

            'city17-delete',

            'city18-list',

            'city18-create',

            'city18-edit',

            'city18-delete',

            'city19-list',

            'city19-create',

            'city19-edit',

            'city19-delete',

            'abroad-list',

            'abroad-create',

            'abroad-edit',

            'abroad-delete',

            'regional-list',

            'regional-create',

            'regional-edit',

            'regional-delete',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
