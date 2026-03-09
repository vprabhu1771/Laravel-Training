<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for the "customers" table
        $customers = [
            [
                'name' => 'John Doe',
                'email' => 'johndoe@gmail.com',
                'gender'
            ],
            [
                'name' => 'Jane Smith'
            ],            
            // Add more departments as needed
        ];

        // Insert the data into the "customers" table
        Customer::insert($customers);
    }
}
