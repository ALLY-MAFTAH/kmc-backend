<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Parking;
use App\Models\Vehicle;
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
                'ward' => "MIKOCHENI",
                'sub_ward' => "MIKOCHENI",
                'capacity' => 45,
                'leader_mobile' => "0714871033",
                'leader_name' => "Bakari Mwakilambe",
                'leader_photo' => "img/leader1.png",
                'status' => true,
            ],

        ])->each(function ($parking) {
           $newParking= Parking::create($parking);
            collect([
                [
                    'parking_id' => $newParking->id,
                    'location_name' => "Manzese ",
                    'latitude' => -6.789574387903087,
                    'longitude' => 39.231051196545415,
                ]

            ])->each(function ($location) use($newParking) {
               $newLocation= Location::create($location);
                $newParking->location()->save($newLocation);
            });
            collect([
                [
                    'reg_number' => "T123 AAA",
                    'owner_id' => 1,
                    'driver_id' => 1,
                    'type' => "Bajaji",
                    'brand' => "TVS",
                    'color' => "Blue",
                    'parking_id' => $newParking->id,

                ],
                [
                    'reg_number' => "T123 BBB",
                    'owner_id' => 2,
                    'driver_id' => 2,
                    'type' => "Pikipiki",
                    'brand' => "Boxer",
                    'color' => "Black",
                    'parking_id' => $newParking->id,

                ],
            ])->each(function ($vehicle) use ($newParking) {
               $newVehicle= Vehicle::create($vehicle);
               $newParking->vehicles()->save($newVehicle);
            });
        });
        collect([
            [
                'pln' => "KMCTNGL/001",
                'name' => "Magomeni Hospital",
                'ward' => "MAGOMENI",
                'sub_ward' => "MAGOMENI",
                'capacity' => 25,
                'leader_mobile' => "0620650411",
                'leader_name' => "Hussein Sabi",
                'leader_photo' => "img/leader2.png",
                'status' => true,
            ],

        ])->each(function ($parking) {
           $newParking= Parking::create($parking);
            collect([
                [
                    'parking_id' => 2,
                    'location_name' => "Magomeni",
                    'latitude' => -6.7967465485235925,
                    'longitude' => 39.23782832538122,
                ],

            ])->each(function ($location) use($newParking) {
               $newLocation= Location::create($location);
                $newParking->location()->save($newLocation);
            });
        });
    }
}
