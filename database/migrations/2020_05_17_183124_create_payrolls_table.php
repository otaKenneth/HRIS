<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            // salaries
            $table->string('type')->nullable();
            $table->float('tndp')->nullable();
            $table->float('per_min')->nullable();
            $table->float('hourly')->nullable();
            $table->float('daily')->nullable();
            $table->float('half')->nullable();
            $table->float('monthly')->nullable();
            $table->float('allowance')->nullable();
            $table->string('allowance_type')->nullable();
            // dtr
            $table->text('work_days')->nullable();
            /* regular, restday, sh, rh, nd, nd.restday, nd.sh, nd.rh */
            $table->float('absences')->nullable();
            $table->float('late')->nullable();
            $table->float('ut')->nullable();
            $table->text('ot')->nullable();
            /* regular, regular.restday, regular.sh, regular.rh, nd, nd.restday, nd.sh, nd.rh */
            $table->text('sl')->nullable();
            $table->text('vl')->nullable();
            $table->float('SH')->nullable();
            $table->float('RH')->nullable();
            // payroll
            $table->float('total_work_days')->nullable();
            $table->float('total_allowance')->nullable();
            $table->float('total_absences')->nullable();
            $table->float('total_late')->nullable();
            $table->float('total_ut')->nullable();
            $table->float('total_ot')->nullable();
            $table->float('total_sl')->nullable();
            $table->float('total_vl')->nullable();
            $table->float('total_paid_sl')->nullable();
            $table->float('total_paid_vl')->nullable();
            $table->float('total')->nullable();
            $table->date('range_from')->nullable();
            $table->date('range_to')->nullable();
            $table->string('range')->nullable();
            $table->boolean('processed')->nullable()->default(false);

            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}
