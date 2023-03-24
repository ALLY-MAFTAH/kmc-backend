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
        Schema::create('parkings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pln')->unique();
            $table->bigInteger('street_id');
            $table->bigInteger('ward_id');
            $table->double('capacity');
            $table->double('no_of_vehicles');
            $table->string('leader_mobile');
            $table->string('name')->nullable();
            $table->string('leader_name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parkings');
    }
};