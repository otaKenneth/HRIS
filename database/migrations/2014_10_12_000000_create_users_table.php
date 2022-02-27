<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // basic information
            $table->bigIncrements('id');
            $table->string('profile')->nullable();
            $table->string('employee_id')->nullable()->unique();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('username')->unique();
            $table->integer('age')->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('cstatus')->nullable();
            $table->integer('religion')->nullable();
            $table->integer('nationality')->nullable();
            $table->string('userlvl')->nullable();
            // contact info
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mnum')->nullable();
            $table->string('tnum')->nullable();
            // job info
            $table->integer('tax')->default(0);
            $table->integer('sss')->default(0);
            $table->integer('philhealth')->default(0);
            $table->integer('pagibig')->default(0);
            // $table->integer('location')->default(0);
            // $table->integer('department')->default(0);
            $table->integer('job_position')->default(0);
            // $table->integer('proj_team')->default(0);
            // $table->integer('head')->default(0);
            // $table->integer('corp_rank')->default(0);
            $table->integer('job_status')->default(0);
            // $table->integer('job_grd')->default(0);
            // employment status
            $table->integer('emp_status')->default(0);
            $table->date('hire_date')->nullable();
            $table->date('training_start')->nullable();
            $table->date('training_evaluation')->nullable();
            $table->date('probi_start')->nullable();
            $table->date('probi_evaluation')->nullable();
            $table->date('reg_start')->nullable();
            $table->date('reg_end')->nullable();
            $table->integer('sl_credits')->nullable();
            $table->integer('vl_credits')->nullable();
            $table->string('rol')->nullable();
            $table->string('remarks')->nullable();
            // 
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
