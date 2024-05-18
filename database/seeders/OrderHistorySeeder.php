<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderHistory;

class OrderHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Order::all()->each(function ($order) {
            OrderHistory::factory()->count(rand(2, 3))->create(['order_id' => $order->id]);
        });
    }
}
