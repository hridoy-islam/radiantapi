<?php

namespace Database\Seeders;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 orders using the Order factory
        Order::factory()->count(10)->create();
    }
}
