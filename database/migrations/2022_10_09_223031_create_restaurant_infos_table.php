<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_infos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('day_from');
            $table->integer('day_to');
            $table->string('time_from');
            $table->string('time_to');
            $table->string('bookable_from');
            $table->string('bookable_to');
            $table->boolean('is_open');
            $table->boolean('reservations_open');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_infos');
    }
};
