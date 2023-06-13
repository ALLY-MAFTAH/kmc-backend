<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
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
                'first_name' => "Juma",
                'middle_name' => "Jumaa",
                'last_name' => "Ally",
                'mobile' => "0714871033",
                'nida' => "199602172121000020",
                'photo' => "--------------------",

            ],

            [
                'first_name' => "Chidako",
                'middle_name' => "",
                'last_name' => "Bakari",
                'mobile' => "0620650411",
                'nida' => "199602172121000023",
                'photo' => "--------------------",

            ],

        ])->each(function ($driver) {
            Driver::create($driver);
        });
    }
}
