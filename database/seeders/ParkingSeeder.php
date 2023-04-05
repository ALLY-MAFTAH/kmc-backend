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
                'pln' => "KMCTNTM/001",
                'name' => "Manzese Darajani",
                'street_id' => 1,
                'ward_id' => 1,
                'capacity' => 45,
                'no_of_vehicles' => 34,
                'leader_mobile' => "0714871033",
                'leader_name' => "Bakari Mwakilambe",
                'status' => true,
            ],
            [
                'pln' => "KMCTNGL/001",
                'name' => "Magomeni Hospital",
                'street_id' => 2,
                'ward_id' => 2,
                'capacity' => 25,
                'no_of_vehicles' => 15,
                'leader_mobile' => "0620650411",
                'leader_name' => "Hussein Sabi",
                'status' => true,
            ],

        ])->each(function ($parking) {
            Parking::create($parking);
        });
    }
}
