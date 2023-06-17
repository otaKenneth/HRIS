<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersSubNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_sub_navigations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('main_nav_id');
            $table->string('name')->unique();
            $table->string('href')->nullable();
            $table->string('icon')->nullable();
            $table->integer('index')->nullable();
            $table->boolean('visible')->default(true);

            $table->timestamps();
            
            $table->index('main_nav_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_sub_navigations');
    }
}
