alergen_food_item<?php

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
        Schema::create('alergen_food_item', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('food_item_id')->index();
            $table->foreign('food_item_id')->references('id')->on('food_items')->onDelete('cascade');

            $table->unsignedBigInteger('alergen_id')->index();
            $table->foreign('alergen_id')->references('id')->on('alergens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_item_alergen');
    }
};
