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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url')->unique();
            $table->text('image_gallery')->nullable();
            $table->string('exterior_colour');
            $table->string('interior_colour');
            $table->string('body_style');
            $table->string('transmission');
            $table->string('stock');
            $table->text('vin');
            $table->integer('km');
            $table->string('engine');
            $table->string('fuel_efficiency');
            $table->string('drivetrain');
            $table->integer('price');
            $table->string('cartype');
            $table->integer('year');
            $table->text('overview');
            $table->string('bluetooth')->nullable();
            $table->string('cruiseControl')->nullable();
            $table->string('smartphoneIntegration')->nullable();
            $table->string('backupCamera')->nullable();
            $table->string('multizoneAC')->nullable();
            $table->string('rearAC')->nullable();
            $table->string('keylessEntry')->nullable();
            $table->string('antiLockBrakes')->nullable();
            $table->string('powerSeats')->nullable();
            $table->string('thirdRowSeating')->nullable();
            $table->string('heatedSeats')->nullable();
            $table->string('remoteStart')->nullable();
            $table->string('keyLessStart')->nullable();
            $table->string('streeingwheelcontrol')->nullable();
            $table->text('exterior')->nullable();
            $table->text('interior')->nullable();
            $table->text('entertainment')->nullable();
            $table->text('mechanical')->nullable();
            $table->text('safety')->nullable();
            $table->text('techspecs')->nullable();
            $table->text('title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->text('og_image')->nullable();
            $table->string('status')->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
