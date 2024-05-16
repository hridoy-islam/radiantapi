<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('url')->unique();
        $table->text('title')->nullable();
        $table->text('meta_description')->nullable();
        $table->text('meta_keywords')->nullable();
        $table->text('og_title')->nullable();
        $table->text('og_description')->nullable();
        $table->text('og_image')->nullable();
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->text('image_gallery')->nullable();
        $table->string('sku')->unique();
        $table->integer('stock');
        $table->string('size')->nullable();
        $table->string('color')->nullable();
        $table->text('description');
        $table->text('short_description')->nullable();
        $table->text('review')->nullable();
        $table->foreignId('brand_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
