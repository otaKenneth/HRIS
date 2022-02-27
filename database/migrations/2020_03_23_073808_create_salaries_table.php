<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->float('tndp')->nullable();
            $table->string('salary_type')->nullable();
            $table->integer('weekly_work_days')->default(0);
            $table->float('allowance')->nullable();
            $table->string('allowance_type')->nullable();
            $table->float('per_min')->nullable();
            $table->float('hourly')->nullable();
            $table->float('daily')->nullable();
            $table->float('half')->nullable();
            $table->float('monthly')->nullable();
            $table->float('increase')->nullable();
            
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
        Schema::dropIfExists('salaries');
    }
}
