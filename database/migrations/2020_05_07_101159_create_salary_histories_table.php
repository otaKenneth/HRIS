<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('salary_id');
            $table->float('tndp')->nullable();
            $table->string('salary_type')->nullable();
            $table->float('allowance')->nullable();
            $table->string('allowance_type')->nullable();
            $table->float('per_min')->nullable();
            $table->float('hourly')->nullable();
            $table->float('daily')->nullable();
            $table->float('half')->nullable();
            $table->float('monthly')->nullable();
            $table->dateTime('from')->nullable();
            
            $table->timestamps();
            $table->index('salary_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_histories');
    }
}
