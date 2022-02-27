<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientRecordExaminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_record_examinations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_record_id');
            $table->string('skin')->nullable();
            $table->string('hair')->nullable();
            $table->string('nails')->nullable();
            $table->string('head')->nullable();
            $table->string('eyes')->nullable();
            $table->string('ears')->nullable();
            $table->string('nose')->nullable();
            $table->string('mouth')->nullable();
            $table->string('throat')->nullable();
            $table->string('neck')->nullable();
            $table->string('cl')->nullable();
            $table->string('heart')->nullable();
            $table->string('abdomen')->nullable();
            $table->string('back')->nullable();
            $table->string('ext')->nullable();
            $table->string('impression')->nullable();

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
        Schema::dropIfExists('patient_record_examinations');
    }
}
