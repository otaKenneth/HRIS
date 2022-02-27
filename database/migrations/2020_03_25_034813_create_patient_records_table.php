<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->string('gen_survey')->nullable();
            $table->integer('bp')->nullable();
            $table->integer('hr')->nullable();
            $table->integer('rr')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('temp')->nullable();
            $table->string('chief_complaint')->nullable();
            // HPI
            $table->string('site')->nullable();
            $table->string('onset')->nullable();
            $table->string('character')->nullable();
            $table->string('radiation')->nullable();
            $table->string('association')->nullable();
            $table->string('time')->nullable();
            $table->string('exacerbating')->nullable();
            $table->string('severity')->nullable();
            $table->string('plt')->nullable();
            // misc
            $table->float('payment')->nullable();
            $table->date('next_visit')->nullable();
            $table->string('note')->nullable();
            $table->boolean('payed')->nullable()->default(false);

            $table->timestamps();

            $table->index('patient_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_records');
    }
}
