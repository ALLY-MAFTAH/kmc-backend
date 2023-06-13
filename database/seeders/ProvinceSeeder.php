<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
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
                'name' => "Kinondoni",
                'status' => true,
            ],
            [
                'name' => "Kawe",
                'status' => true,

            ],

        ])->each(function ($province) {
            Province::create($province);
        });
    }
}
