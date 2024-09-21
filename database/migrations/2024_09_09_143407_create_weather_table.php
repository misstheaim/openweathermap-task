<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weather', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('city')->nullable(false);
            $table->dateTimeTz('date_time');
            $table->string('weather_name');
            $table->float('latitude');
            $table->float('longitude');
            $table->float('temperature');
            $table->float('min_temperature');
            $table->float('max_temperature');
            $table->float('pressure');
            $table->float('humidity');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather');
    }
};
