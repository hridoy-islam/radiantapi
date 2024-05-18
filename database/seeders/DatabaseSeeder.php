<?php

use Illuminate\Database\Seeder;

use Database\Seeders\CategorySeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\SizeSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\CouponSeeder;
use Database\Seeders\ContactSeeder;
use Database\Seeders\ProductVariationSeeder;
use Database\Seeders\OrderItemSeeder;
use Database\Seeders\OrderHistorySeeder;
use Database\Seeders\PaymentsSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            ColorSeeder::class,
            SizeSeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            CouponSeeder::class,
            ContactSeeder::class,
            ProductVariationSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            OrderHistorySeeder::class,
            PaymentsSeeder::class,
            // Add more seeders here as needed
        ]);
    }
}
