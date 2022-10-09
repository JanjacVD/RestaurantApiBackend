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
            $table->boolean('is_open');
            $table->json('about_us_title');
            $table->json('about_us_text');
            $table->json('icon_translations');
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
