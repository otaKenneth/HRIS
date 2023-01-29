<?php

use Illuminate\Database\Seeder;

class PayrollSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $settings = [];

    public function run()
    {
        $s = $this->setSettingsArr();
        if ($s) DB::table('settings')->insert($this->settings);
    }

    private function setSettingsArr ()
    {
        $this->createInsertArr('payroll.defaults.from','1');
        $this->createInsertArr('payroll.defaults.every','15');
        $this->createInsertArr('payroll.defaults.efectivitydate','04/01/2020');
        $this->createInsertArr('payroll.sh.unworked','0%');
        $this->createInsertArr('payroll.sh.worked','30%');
        $this->createInsertArr('payroll.sh.worked&rd','30%');
        $this->createInsertArr('payroll.rh.regular.unworked','100%');
        $this->createInsertArr('payroll.rh.regular.worked','200%');
        $this->createInsertArr('payroll.rh.regular.worked&rd','60%');
        $this->createInsertArr('payroll.ot.regular','125%');
        $this->createInsertArr('payroll.ot.restday','169%');
        $this->createInsertArr('payroll.ot.SH','169%');
        $this->createInsertArr('payroll.ot.SH&rd','195%');
        $this->createInsertArr('payroll.ot.RH','260%');
        $this->createInsertArr('payroll.ot.RH&rd','338%');
        $this->createInsertArr('payroll.ot.nd.regular','137.5%');
        $this->createInsertArr('payroll.ot.nd.restday','185.9%');
        $this->createInsertArr('payroll.ot.nd.SH','185.9%');
        $this->createInsertArr('payroll.ot.nd.SH&rd','214.5%');
        $this->createInsertArr('payroll.ot.nd.RH','286%');
        $this->createInsertArr('payroll.ot.nd.RH&rd','371.8%');
        $this->createInsertArr('payroll.restday','135%');
        $this->createInsertArr('payroll.nd.regular','150%');
        $this->createInsertArr('payroll.nd.restday','175%');
        $this->createInsertArr('payroll.nd.sh.unworked','0%');
        $this->createInsertArr('payroll.nd.sh.worked','200%');
        $this->createInsertArr('payroll.nd.sh.worked&rd','210%');
        $this->createInsertArr('payroll.nd.rh.unworked','200%');
        $this->createInsertArr('payroll.nd.rh.worked','215%');
        $this->createInsertArr('payroll.nd.rh.worked&rd','280.5%');

        return true;
    }

    private function createInsertArr($key, $value)
    {
        array_push($this->settings, [
            'key' => $key, 
            'value' => $value,
            'created_at' => date("Y-m-d h:m:s"),
            'updated_at' => date("Y-m-d h:m:s"),
        ]);
    }
}
