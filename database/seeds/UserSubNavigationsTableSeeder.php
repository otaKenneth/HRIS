<?php

use Illuminate\Database\Seeder;

class UserSubNavigationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subnavs = array_merge(
            $this->getGeneralNavs(), $this->getTimekeepNavs(),
            $this->getPayrollNavs(), $this->getExtraNavs()
        );

        DB::table('users_sub_navigations')->insert($subnavs);
    }

    private function getGeneralNavs()
    {
        return [
            [
                "main_nav_id" => 1,
                "name" => "Dashboard",
                "href" => "/home",
                "icon" => "fa fa-tachometer-alt",
                "index" => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "main_nav_id" => 1,
                "name" => "Calendar",
                "href" => "/Calendar",
                "icon" => "fa fa-calendar",
                "index" => 2,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "main_nav_id" => 1,
                "name" => "Patients",
                "href" => "#",
                "icon" => "fa fa-user-injured",
                "index" => 3,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "main_nav_id" => 1,
                "name" => "Employees",
                "href" => "#",
                "icon" => "fas fa-user-tie",
                "index" => 4,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
        ];
    }

    private function getTimekeepNavs()
    {
        return [
            [
                "main_nav_id" => 2,
                "name" => "Shifts",
                "href" => "/Shift",
                "icon" => "fa fa-business-time",
                "index" => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "main_nav_id" => 2,
                "name" => "Daily Time Record",
                "href" => "/DTR",
                "icon" => "fa fa-user-clock",
                "index" => 2,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "main_nav_id" => 2,
                "name" => "Requests",
                "href" => "#",
                "icon" => "fa fa-file-o",
                "index" => 3,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
        ];
    }

    private function getPayrollNavs()
    {
        return [
            [
                "main_nav_id" => 3,
                "name" => "Computation",
                "href" => "/Payroll/Computation",
                "icon" => "fa fa-calculator",
                "index" => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "main_nav_id" => 3,
                "name" => "Pay Slip",
                "href" => "/Payroll/PaySlip",
                "icon" => "fa fa-file-alt",
                "index" => 2,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "main_nav_id" => 3,
                "name" => "Settings",
                "href" => "/Payroll/Settings",
                "icon" => "fa fa-cogs",
                "index" => 3,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
        ];
    }

    private function getExtraNavs()
    {
        return [
            [
                "main_nav_id" => 4,
                "name" => "Reports",
                "href" => "/Reports",
                "icon" => "fa fa-calculator",
                "index" => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "main_nav_id" => 4,
                "name" => "Holidays",
                "href" => "/Holiday",
                "icon" => "fa fa-file-alt",
                "index" => 2,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "main_nav_id" => 4,
                "name" => "Look-up",
                "href" => "/Lookup",
                "icon" => "fa fa-cogs",
                "index" => 3,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
        ];
    }

    private function getMainSettingNavs()
    {
        return [
            [
                "main_nav_id" => 5,
                "name" => "User Navigation Connections",
                "href" => "Main-Settings/User-Nav-Connections",
                "icon" => "fa fa-user",
                "index" => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
        ];
    }
}
