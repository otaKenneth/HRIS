<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LookupsTableSeeder::class,
            UsersTableSeeder::class,
            HolidaysTableSeeder::class,
            PayrollSettingsTableSeeder::class
        ]);
    }
}
