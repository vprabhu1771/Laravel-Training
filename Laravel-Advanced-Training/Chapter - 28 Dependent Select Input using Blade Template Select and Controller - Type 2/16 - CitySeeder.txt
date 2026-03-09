<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\State;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find a country by name
        $state = State::where('name', 'tamil nadu')->first();

        // You can add more cities as needed
        $cities = [
            [$state->id, "Ariyalur"],
            [$state->id, "Chengalpattu"],
            [$state->id, "Chennai"],
            [$state->id, "Coimbatore"],
            [$state->id, "Cuddalore"],
            [$state->id, "Dharmapuri"],
            [$state->id, "Dindigul"],
            [$state->id, "Erode"],
            [$state->id, "Kallakurichi"],
            [$state->id, "Kancheepuram"],
            // Add more cities here
        ];

        // Insert data into the cities table        
        foreach ($cities as $citiesData) {
            City::insert([
                'state_id' => $citiesData[0],
                'name' => $citiesData[1],
                // 'code' => $stateData[2],
            ]);
        }
    }
}
