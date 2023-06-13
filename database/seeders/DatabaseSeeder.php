<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        $this->call(RoleUserSeeder::class);
        $this->call(OwnerSeeder::class);
        $this->call(WardSeeder::class);
        $this->call(StreetSeeder::class);
        $this->call(ParkingSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(StickerSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(SubWardSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(DriverSeeder::class);
        $this->call(AlertSeeder::class);
    }
}
