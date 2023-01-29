<?php

use Illuminate\Database\Seeder;

class ShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shifts')->insert([
            'code' => 'off',
            'opentime' => 0,
            'breaks' => 0,
            'in' => NULL,
            'breakIn' => NULL,
            'breakOut' => NULL,
            'out' => NULL,
            'created_at' => date("Y-m-d h:m:s"),
            'updated_at' => date("Y-m-d h:m:s"),
        ]);
    }
}
