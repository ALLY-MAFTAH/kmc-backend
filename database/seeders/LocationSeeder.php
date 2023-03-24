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
                'address_name' => "I Sembeti, Dar es salaam",
                'latitude' => "12.23435565767",
                'longitude' => "2.23435565767",
            ],


        ])->each(function ($location) {
            Location::create($location);
        });
    }
}
