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
        Schema::create('hotel_stay_rates_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('hotel_name')->index('hotel_name_idx');
            $table->dateTime('date_of_stay')->index('date_of_stay_idx');
            $table->dateTime('date_scraped')->index('date_scraped_idx');
            $table->unsignedDouble('rate_per_night');
            $table->uuid('old_uuid')->index('old_uuid_idx');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_hotel_scraped_data');
    }
};
