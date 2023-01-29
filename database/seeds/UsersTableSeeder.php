<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'firstname' => Str::random(10),
            'middlename' => Str::random(10),
            'lastname' => Str::random(10),
            'email_verified_at' => date("Y-m-d h:m:s"),
            'job_position' => 21,
            'job_status' => 22,
            'userlvl' => 27,
            'password' => bcrypt('password123'),
            'created_at' => date("Y-m-d h:m:s"),
            'updated_at' => date("Y-m-d h:m:s"),
        ];

        $admins = [
            array_merge($users, [
                'username' => 'superadmin',
                'job_position' => 19,
                'job_status' => 22,
                'userlvl' => 25,
                'email' => Str::random(10).'@testmail.com',
            ]),
            array_merge($users, [
                'username' => 'admin',
                'job_position' => 18,
                'job_status' => 22,
                'userlvl' => 26,
                'email' => Str::random(10).'@testmail.com',
            ])
        ];

        DB::table('users')->insert($admins);

        for ($i=0; $i < 3; $i++) { 
            DB::table('users')->insert(array_merge($users, [
                'employee_id' => Str::random(15),
                'username' => Str::random(10),
                'email' => Str::random(10).'@testmail.com'
            ]));
        }

        DB::table('super_admins')->insert([
            'user_id' => 1,
            'created_at' => date("Y-m-d h:m:s"),
            'updated_at' => date("Y-m-d h:m:s"),
        ]);

        DB::table('admins')->insert([
            'user_id' => 2,
            'created_at' => date("Y-m-d h:m:s"),
            'updated_at' => date("Y-m-d h:m:s"),
        ]);
    }
}
