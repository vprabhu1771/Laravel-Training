<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Sample data for the "products" table
         $products = [
            [
                'name' => 'Laptop',
                'price' => 1200.00,
                'category_id' => 1
            ],
            [
                'name' => 'Smartphone',
                'price' => 500.00,
                'category_id' => 1
            ],
            [
                'name' => 'T-Shirt',
                'price' => 25.00,
                'category_id' => 2
            ],
            [
                'name' => 'Washing Machine',
                'price' => 800.00,
                'category_id' => 3
            ],
            // Add more products as needed
        ];

        // Insert the data into the "products" table
        Product::insert($products);
    }
}
