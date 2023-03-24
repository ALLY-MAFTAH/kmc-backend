<?php

namespace Database\Seeders;

use App\Models\Parking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'pln' => "KMCTNTM/001---KMCTNTM134",
                'street_id' => 1,
                'ward_id' => 1,
                'capacity' => 45,
                'no_of_vehicles' => 34,
                'leader_mobile' => "0714871033",
                'name' => "Manzese Darajani",
                'leader_name' => "Bakari Mwakilambe",

            ],
            [
                'pln' => "KMCTNGL/001---KMCTNGL134",
                'street_id' => 2,
                'ward_id' => 2,
                'capacity' => 25,
                'no_of_vehicles' => 15,
                'leader_mobile' => "0620650411",
                'name' => "Kwa Warioba",
                'leader_name' => "Hussein Sabi",
            ],

        ])->each(function ($parking) {
            Parking::create($parking);
        });
    }
}
