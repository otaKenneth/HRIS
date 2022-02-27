<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyTimeRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_time_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->text('tag')->nullable();
            $table->integer('day');
            $table->time('schedule_in')->nullable();
            $table->time('schedule_breakOut')->nullable();
            $table->time('schedule_breakIn')->nullable();
            $table->time('schedule_out')->nullable();
            $table->time('in')->nullable();
            $table->time('breakOut')->nullable();
            $table->time('breakIn')->nullable();
            $table->time('out')->nullable();
            $table->time('otIn')->nullable();
            $table->time('otOut')->nullable();
            $table->char('workOn', 2)->nullable();
            $table->decimal('late')->nullable();
            $table->decimal('undertime')->nullable();
            $table->string('leave')->nullable();
            $table->decimal('total')->nullable();
            $table->decimal('regular')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
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
        Schema::dropIfExists('daily_time_records');
    }
}
