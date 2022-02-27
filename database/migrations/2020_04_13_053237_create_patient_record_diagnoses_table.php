<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientRecordDiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_record_diagnoses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_record_id');
            $table->string('diagnosis')->nullable();
            $table->timestamps();
            
            $table->index('patient_record_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_record_diagnoses');
    }
}
