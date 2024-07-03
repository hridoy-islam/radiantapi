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
        Schema::create('trade_your_cars', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('email');
            $table->string('current_car_brand');
            $table->string('current_car_model');
            $table->year('current_car_year');
            $table->integer('current_car_mileage');
            $table->string('current_car_transmission_type');
            $table->json('current_car_photos')->nullable(); // Assuming photos are stored as JSON array of image paths
            $table->text('current_car_special_notes')->nullable();
            $table->string('expected_car_model');
            $table->year('expected_car_year');
            $table->integer('expected_car_mileage');
            $table->string('expected_car_transmission_type');
            $table->text('expected_car_special_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_your_cars');
    }
};
