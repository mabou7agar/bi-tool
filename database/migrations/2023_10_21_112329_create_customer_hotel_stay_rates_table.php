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
        Schema::create('customer_hotel_stay_rates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('customer_id')->index('customer_id_idx');
            $table->uuid('hotel_id')->index('customer_id_idx');;
            $table->dateTime('date_of_stay');
            $table->unsignedInteger('rate')->index('rate_idx');;
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
