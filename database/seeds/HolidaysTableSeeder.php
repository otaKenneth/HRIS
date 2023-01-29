<?php

use Illuminate\Database\Seeder;

class HolidaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $holidays = [];
    public function run()
    {
        $s = $this->setInsertArr();
        if ($s) DB::table('holidays')->insert($this->holidays);
    }

    private function setInsertArr ()
    {
        $this->createInsertArr('RH','2020-01-01','2020-01-01','New Year\'s Day','#ed8936','#fff');
        $this->createInsertArr('SH','2020-01-02','2020-01-02','Extended New Year\'s Day','#d6bcfa','#000');
        $this->createInsertArr('RH','2020-01-03','2020-01-03','Sample Holiday',NULL,NULL);
        $this->createInsertArr('RH','2020-04-09','2020-04-09','Araw ng Kagitingan',NULL,NULL);
        $this->createInsertArr('RH','2020-04-09','2020-04-09','Maundy Thursday',NULL,NULL);
        $this->createInsertArr('RH','2020-04-10','2020-04-10','Good Friday',NULL,NULL);
        $this->createInsertArr('RH','2020-05-01','2020-05-01','Labor Day',NULL,NULL);
        $this->createInsertArr('RH','2020-06-12','2020-06-12','Independence Day',NULL,NULL);
        $this->createInsertArr('RH','2020-08-31','2020-08-31','National Hero\'s Day',NULL,NULL);
        $this->createInsertArr('RH','2020-11-30','2020-11-30','Bonifacio Day',NULL,NULL);
        $this->createInsertArr('RH','2020-12-25','2020-12-25','Christmas Day',NULL,NULL);
        $this->createInsertArr('RH','2020-12-30','2020-12-30','Rizal Day',NULL,NULL);
        $this->createInsertArr('SH','2020-01-25','2020-01-25','Chinese New Year','#d6bcfa','#000');
        $this->createInsertArr('SH','2020-02-25','2020-02-25','EDSA Revolution Anniversary','#d6bcfa','#000');
        $this->createInsertArr('SH','2020-04-11','2020-04-11','Black Saturday','#d6bcfa','#000');
        $this->createInsertArr('SH','2020-08-21','2020-08-21','Ninoy Aquino Day','#d6bcfa','#000');
        $this->createInsertArr('SH','2020-11-01','2020-11-01','All Saints\' Day','#d6bcfa','#000');
        $this->createInsertArr('SH','2020-12-08','2020-12-08','Feast of the Immaculate Conception of Mary','#d6bcfa','#000');
        $this->createInsertArr('SH','2020-12-31','2020-12-31','New Year\'s Eve','#d6bcfa','#000');
        $this->createInsertArr('SH','2020-11-02','2020-11-02','All Souls\' Day','#d6bcfa','#000');
        $this->createInsertArr('SH','2020-12-24','2020-12-24','Christmas Eve','#d6bcfa','#000');

        return true;
    }

    public function createInsertArr ($type, $from, $to, $title, $bg, $color)
    {
        array_push($this->holidays, [
            'type' => $type, 
            'from' => $from,
            'to' => $to,
            'title' => $title,
            'bg' => $bg,
            'color' => $color,
            'created_at' => date("Y-m-d h:m:s"),
            'updated_at' => date("Y-m-d h:m:s"),
        ]);
    }
}
