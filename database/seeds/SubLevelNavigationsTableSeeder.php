<?php

use Illuminate\Database\Seeder;

class SubLevelNavigationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subnavs = array_merge(
            $this->getGeneralNavs(), $this->getTimekeepNavs()
        );

        DB::table('sub_level_navigations')->insert($subnavs);
    }

    private function getGeneralNavs()
    {
        return [
            [
                "sub_nav_id" => 3,
                "name" => "List",
                "href" => "Patients",
                "index" => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "sub_nav_id" => 4,
                "name" => "List",
                "href" => "Employees",
                "index" => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "sub_nav_id" => 4,
                "name" => "Schedule",
                "href" => "Schedule",
                "index" => 2,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "sub_nav_id" => 4,
                "name" => "Salary",
                "href" => "Salary",
                "index" => 3,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
        ];
    }

    private function getTimekeepNavs()
    {
        return [
            [
                "sub_nav_id" => 7,
                "name" => "Leave",
                "href" => "Leave",
                "index" => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "sub_nav_id" => 7,
                "name" => "OfficialBusiness",
                "href" => "OB",
                "index" => 2,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "sub_nav_id" => 7,
                "name" => "Override",
                "href" => "Override",
                "index" => 3,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "sub_nav_id" => 7,
                "name" => "Overtime",
                "href" => "Overtime",
                "index" => 4,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
        ];
    }

    function getMainSettingsNavs() {
        return [
            [
                "sub_nav_id" => 14,
                "name" => "User Navigations",
                "href" => "Settings/user-navigations",
                "index" => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
        ];
    }
}
