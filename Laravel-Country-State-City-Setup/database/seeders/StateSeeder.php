<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Country;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find a country by name
        $country = Country::where('name', 'india')->first();

        // You can add more states as needed
        $states = [
            [$country->id, "Andaman and Nicobar Islands", "AN"],
            [$country->id, "Andhra Pradesh", "AP"],
            [$country->id, "Arunachal Pradesh", "AR"],
            [$country->id, "Assam", "AS"],
            [$country->id, "Bihar", "BR"],
            [$country->id, "Chhattisgarh", "CG"],
            [$country->id, "Chandigarh", "CH"],
            [$country->id, "Dadra and Nagar Haveli", "DN"],
            [$country->id, "Daman and Diu", "DD"],
            [$country->id, "Delhi", "DL"],
            [$country->id, "Goa", "GA"],
            [$country->id, "Gujarat", "GJ"],
            [$country->id, "Haryana", "HR"],
            [$country->id, "Himachal Pradesh", "HP"],
            [$country->id, "Jammu and Kashmir", "JK"],
            [$country->id, "Jharkhand", "JH"],
            [$country->id, "Karnataka", "KA"],
            [$country->id, "Kerala", "KL"],
            [$country->id, "Ladakh", "LA"],
            [$country->id, "Lakshadweep", "LD"],
            [$country->id, "Madhya Pradesh", "MP"],
            [$country->id, "Maharashtra", "MH"],
            [$country->id, "Manipur", "MN"],
            [$country->id, "Meghalaya", "ML"],
            [$country->id, "Mizoram", "MZ"],
            [$country->id, "Nagaland", "NL"],
            [$country->id, "Odisha", "OD"],
            [$country->id, "Punjab", "PB"],
            [$country->id, "Pondicherry", "PY"],
            [$country->id, "Rajasthan", "RJ"],
            [$country->id, "Sikkim", "SK"],
            [$country->id, "Tamil Nadu", "TN"],
            [$country->id, "Telangana", "TS"],
            [$country->id, "Tripura", "TR"],
            [$country->id, "Uttar Pradesh", "UP"],
            [$country->id, "Uttarakhand", "UK"],
            [$country->id, "West Bengal", "WB"],
            // Add more states here
        ];

        // Insert data into the states table        
        foreach ($states as $stateData) {
            State::insert([
                'country_id' => $stateData[0],
                'name' => $stateData[1],
                'code' => $stateData[2],
            ]);
        }
    }
}
