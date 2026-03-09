<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Sale;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for the "sales" table
        $sales = [
            [
                'customer_id' => 1,
                'sale_date' => '2023-01-15'
            ],
            [
                'customer_id' => 2,
                'sale_date' => '2023-02-20'
            ],
            
            // Add more sales as needed
        ];

        // Insert the data into the "sales" table
        Sale::insert($sales);
    }
}
