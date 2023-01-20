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
        Schema::create('trains', function (Blueprint $table) {
            $table->id();
            $table->char('number', 4);
            $table->string('departure_place');
            $table->time('departure_time');
            $table->date('departure_date');
            $table->string('arrival_place');
            $table->time('arrival_time');
            $table->timestamps();
            $table->index(['number', 'departure_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trains');
    }
};
