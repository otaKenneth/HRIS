<?php

use Illuminate\Database\Seeder;

class UserNavigationsConnectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_navigations_connections')->insert(
            [
                'user_id' => 1,
                'main_nav_id' => 1,
                'sub_nav_id' => 1,
                'created_at' => date("Y-m-d h:m:s"),
                'updated_at' => date("Y-m-d h:m:s"),
            ]
        );
    }
}
