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
        $connection = $this->setUserNavigations();
        DB::table('user_navigations_connections')->insert($connection);
    }

    private function setUserNavigations()
    {
        $new_arr = [];
        $arr = [
            'user_id' => 1,
            'main_nav_id' => 1,
            'created_at' => date("Y-m-d h:m:s"),
            'updated_at' => date("Y-m-d h:m:s"),
        ];

        for ($i=1; $i <= 4; $i++) { 
            array_push($new_arr, 
                array_merge($arr, ['sub_nav_id' => $i])
            );
        }

        return $new_arr;
    }
}
