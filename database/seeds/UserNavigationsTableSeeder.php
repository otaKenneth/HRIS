<?php

use Illuminate\Database\Seeder;

class UserNavigationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $navigations = [
            [
                "name" => "General",
                "href" => "",
                "icon" => "",
                "index" => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "name" => "Timekeep",
                "href" => "",
                "icon" => "",
                "index" => 2,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "name" => "Payroll",
                "href" => "",
                "icon" => "",
                "index" => 3,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                "name" => "Extra",
                "href" => "",
                "icon" => "",
                "index" => 4,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
        ];

        DB::table('users_navigations')->insert($navigations);
    }
}
