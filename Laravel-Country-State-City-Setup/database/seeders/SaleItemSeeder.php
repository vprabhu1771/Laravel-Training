<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SaleItem;

class SaleItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for the "sale_items " table
        $sale_items  = [
            [
                'sale_id' => 1,
                'product_id' => 1,
                'quantity' => 2,
                'price' => 2400.00,
            ],
            [
                'sale_id' => 1,
                'product_id' => 3,
                'quantity' => 3,
                'price' => 75.00,
            ],
            [
                'sale_id' => 2,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 500.00,
            ],
            [
                'sale_id' => 2,
                'product_id' => 4,
                'quantity' => 1,
                'price' => 800.00,
            ],
            
            // Add more sale_items  as needed
        ];

        // Insert the data into the "sale_items " table
        SaleItem::insert($sale_items);
    }
}
