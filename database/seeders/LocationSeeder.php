<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
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
                'parking_id' => 1,
                'location_name' => "Manzese Darajani",
                'latitude' => -6.789574387903087,
                'longitude' => 39.231051196545415,
            ],
            [
                'parking_id' => 2,
                'location_name' => "Tandale Hospital",
                'latitude' => -6.7967465485235925,
                'longitude' => 39.23782832538122,
            ],
        ])->each(function ($location) {
            Location::create($location);
        });
    }
}
