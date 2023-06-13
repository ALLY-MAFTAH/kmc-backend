<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
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
                'reg_number' => "T123 AAA",
                'owner_id' => 1,
                'driver_id' => 1,
                'type' => "Bajaji",
                'brand' => "TVS",
                'color' => "Blue",
                'parking_id' => 1,

            ],
            [
                'reg_number' => "T123 BBB",
                'owner_id' => 2,
                'driver_id' => 2,
                'type' => "Pikipiki",
                'brand' => "Boxer",
                'color' => "Black",
                'parking_id' => 2,
            ],
        ])->each(function ($vehicle) {
            Vehicle::create($vehicle);
        });
    }
}
