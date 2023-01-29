<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LookupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lookups = [
            [
                'label' => "Civil Status",
                'key' => "cstatus",
                'value' => "Single",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Civil Status",
                'key' => "cstatus",
                'value' => "Married",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Civil Status",
                'key' => "cstatus",
                'value' => "Married",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Department",
                'key' => "department",
                'value' => "Information Technology",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Department",
                'key' => "department",
                'value' => "Human Resource",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Department",
                'key' => "department",
                'value' => "Accounting",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Religion",
                'key' => "religion",
                'value' => "Catholic",
                'index' => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Religion",
                'key' => "religion",
                'value' => "Seventh-day Adventist",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Religion",
                'key' => "religion",
                'value' => "Seventh-day Adventist",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Gender",
                'key' => "gender",
                'value' => "Male",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Gender",
                'key' => "gender",
                'value' => "Female",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Nationality",
                'key' => "nationality",
                'value' => "Filipino",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Nationality",
                'key' => "nationality",
                'value' => "American",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Nationality",
                'key' => "nationality",
                'value' => "Chinese",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Nationality",
                'key' => "nationality",
                'value' => "Japanese",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Location",
                'key' => "location",
                'value' => "Mandaluyong",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Location",
                'key' => "location",
                'value' => "Calumpit, Bulacan",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Job Position",
                'key' => "job_position",
                'value' => "Admin",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Job Position",
                'key' => "job_position",
                'value' => "System Admin",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Job Position",
                'key' => "job_position",
                'value' => "Doctor",
                'index' => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Job Position",
                'key' => "job_position",
                'value' => "Nurse",
                'index' => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Job Status",
                'key' => "job_status",
                'value' => "Regular",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Job Status",
                'key' => "job_status",
                'value' => "Probationary",
                'index' => 0,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "Job Status",
                'key' => "job_status",
                'value' => "Trainee",
                'index' => 3,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "User Level",
                'key' => "userlvl",
                'value' => "Super Admin",
                'index' => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "User Level",
                'key' => "userlvl",
                'value' => "Admin",
                'index' => 2,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
            [
                'label' => "User Level",
                'key' => "userlvl",
                'value' => "Employee",
                'index' => 3,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ],
        ];

        DB::table('lookups')->insert($lookups);
    }
}
