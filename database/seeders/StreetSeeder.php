<?php

namespace Database\Seeders;

use App\Models\Street;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StreetSeeder extends Seeder
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
                'name' => "Tegeta A",
                'status' => true,
                'sub_ward_id' => 1
            ],
            [
                'name' => "Tegeta B",
                'status' => true,
                'sub_ward_id' => 1
            ],
            [
                'name' => "Goba Njia Nne",
                'status' => true,
                'sub_ward_id' => 2
            ],
            [
                'name' => "Goba Center",
                'status' => true,
                'sub_ward_id' => 2
            ],

        ])->each(function ($street) {
            Street::create($street);
        });
    }
}
