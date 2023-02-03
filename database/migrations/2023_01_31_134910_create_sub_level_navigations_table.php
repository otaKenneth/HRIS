<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubLevelNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_level_navigations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sub_nav_id');
            $table->string('name')->nullable();
            $table->string('href')->nullable();
            $table->integer('index')->nullable();

            $table->timestamps();

            $table->index('sub_nav_id');
            $table->foreign('sub_nav_id')
                ->references('id')->on('users_sub_navigations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_level_navigations');
    }
}
