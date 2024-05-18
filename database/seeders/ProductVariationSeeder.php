<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductVariation;

class ProductVariationSeeder extends Seeder
{
    public function run()
    {
        ProductVariation::factory()->count(20)->create();
    }
}
