<?php

namespace Database\Seeders;

use App\Models\Owner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
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
                'first_name' => "Othman",
                'middle_name' => "Abubakar",
                'last_name' => "Ally",
                'mobile' => "0714871033",
                'nida' => "199602172121000020",
                'photo' => "--------------------",

            ],

            [
                'first_name' => "Ndaro",
                'middle_name' => "",
                'last_name' => "Mwakipasile",
                'mobile' => "0620650411",
                'nida' => "199602172121000023",
                'photo' => "--------------------",

            ],

        ])->each(function ($owner) {
            Owner::create($owner);
        });
    }
}
