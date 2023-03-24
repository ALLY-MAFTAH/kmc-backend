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
            ],
            [
                'name' => "Goba",
                'status' => true,
            ],
            [
                'name' => "Wazi",
                'status' => true,
            ],
            [
                'name' => "Mabwepande",
                'status' => true,
            ],
            [
                'name' => "Makongo",
                'status' => true,
            ],
            [
                'name' => "Mbezi Juu",
                'status' => true,
            ],
            [
                'name' => "Ndugumbi",
                'status' => true,
            ],
            [
                'name' => "Mzimuni",
                'status' => true,
            ],
            [
                'name' => "Mwananyamala",
                'status' => true,
            ],
            [
                'name' => "Makumbusho",
                'status' => true,
            ],
            [
                'name' => "Makurumla",
                'status' => true,
            ],
            [
                'name' => "Msasani",
                'status' => true,
            ],
            [
                'name' => "Mikocheni",
                'status' => true,
            ],
            [
                'name' => "Mbweni",
                'status' => true,
            ],
            [
                'name' => "Mbezi",
                'status' => true,
            ],
            [
                'name' => "Magomeni",
                'status' => true,
            ],
            [
                'name' => "Kunduchi",
                'status' => true,
            ],
            [
                'name' => "Kinondoni",
                'status' => true,
            ],
            [
                'name' => "Kimara",
                'status' => true,
            ],
            [
                'name' => "Kijitonyama",
                'status' => true,
            ],
            [
                'name' => "Kigogo",
                'status' => true,
            ],
            [
                'name' => "Kibamba",
                'status' => true,
            ],
            [
                'name' => "Kawe",
                'status' => true,
            ],
            [
                'name' => "Hananasif",
                'status' => true,
            ],

        ])->each(function ($ward) {
            Ward::create($ward);
        });
    }
}
