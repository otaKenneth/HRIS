<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientPastMedicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_past_medications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_record_id');
            $table->string('name')->nullable();
            $table->string('dose')->nullable();
            $table->string('frequency')->nullable();
            $table->string('duration')->nullable();
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
        Schema::dropIfExists('patient_past_medications');
    }
}
