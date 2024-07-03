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
            $table->string('vin')->unique();
            $table->integer('km');
            $table->string('engine');
            $table->string('fuel_efficiency_city');
            $table->string('fuel_efficiency_hwy');
            $table->string('drivetrain');
            $table->integer('price');
            $table->text('overview');
            $table->json('features')->nullable();
            $table->json('exterior')->nullable();
            $table->json('interior')->nullable();
            $table->json('entertainment')->nullable();
            $table->json('mechanical')->nullable();
            $table->json('safety')->nullable();
            $table->json('techspecs')->nullable();
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
