<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_ranges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('leave_id');
            $table->date('date');
            $table->string('day');
            $table->boolean('pay');
            
            $table->timestamps();

            $table->index('leave_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_ranges');
    }
}
