<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientHospitalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_hospitalizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_record_id');
            $table->string('hospital')->nullable();
            $table->date('h_date')->nullable();
            $table->string('dx')->nullable();
            $table->string('duration')->nullable();
            $table->string('attending')->nullable();
            $table->string('remarks')->nullable();

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
        Schema::dropIfExists('patient_hospitalizations');
    }
}
