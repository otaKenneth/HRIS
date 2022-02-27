<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            // basic
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            // $table->string('username')->nullable()->unique();
            $table->integer('age')->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('gender')->nullable();
            // contact
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('pnum')->nullable();
            // address
            $table->string('address')->nullable();
            $table->integer('town')->nullable();
            $table->integer('province')->nullable();
            $table->string('country')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
