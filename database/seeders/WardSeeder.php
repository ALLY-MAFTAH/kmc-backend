<?php

namespace Database\Seeders;

use App\Models\Ward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WardSeeder extends Seeder
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
                'name' => "Bunju",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Goba",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Wazi",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Mabwepande",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Makongo",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Mbezi Juu",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Ndugumbi",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Mzimuni",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Mwananyamala",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Makumbusho",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Makurumla",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Msasani",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Mikocheni",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Mbweni",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Mbezi",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Magomeni",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Kunduchi",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Kinondoni",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Kimara",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Kijitonyama",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Kigogo",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Kibamba",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Kawe",
                'status' => true,
                'province_id'=>1,
            ],
            [
                'name' => "Hananasif",
                'status' => true,
                'province_id'=>1,
            ],

        ])->each(function ($ward) {
            Ward::create($ward);
        });
    }
}
