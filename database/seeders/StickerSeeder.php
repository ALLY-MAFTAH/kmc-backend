<?php

namespace Database\Seeders;

use App\Models\Sticker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StickerSeeder extends Seeder
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
                'vehicle_id' => 1,
                'number' => "12345678910",
                'period' => "2022",
                'start_date' => "2022-10-05",
                'end_date' => "2023-10-05",
                'is_valid' => true,
            ],

            [
                'vehicle_id' => 2,
                'number' => "12345678911",
                'period' => "2021",
                'start_date' => "2021-7-15",
                'end_date' => "2022-7-15",
                'is_valid' => false,
            ],

        ])->each(function ($sticker) {
            Sticker::create($sticker);
        });
    }
}
