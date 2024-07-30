<?php

use Illuminate\Database\Seeder;

use Database\Seeders\ContactSeeder;
use Database\Seeders\CarsTableSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\FinanceApplicantSeeder;
use Database\Seeders\SellYourCarSeeder;
use Database\Seeders\BlogPostSeeder;
use Database\Seeders\TradeYourCarSeeder;

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
            //CarsTableSeeder::class,
            ContactSeeder::class,
            UserSeeder::class,
            FinanceApplicantSeeder::class,
            SellYourCarSeeder::class,
            BlogPostSeeder::class,
            TradeYourCarSeeder::class
        ]);
    }
}
