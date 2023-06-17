<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserNavigationsConnectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin_navs = [
            [
                'user_id' => 1,
                'main_nav_id' => 1,
                'sub_nav_id' => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'user_id' => 1,
                'main_nav_id' => 3,
                'sub_nav_id' => 10,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'user_id' => 1,
                'main_nav_id' => 4,
                'sub_nav_id' => 12,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'user_id' => 1,
                'main_nav_id' => 4,
                'sub_nav_id' => 13,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'user_id' => 1,
                'main_nav_id' => 5,
                'sub_nav_id' => 14,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
        ];

        foreach ($superadmin_navs as $key => $nav) {
            DB::table('user_navigations_connections')->insert($nav);
        }
    }
}
