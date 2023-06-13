<?php

namespace Database\Seeders;

use App\Models\Alert;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AlertSeeder extends Seeder
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
                'msg' => "Unakumbushwa kuna na Lorem ipsum, dolor sit amet consectetur adipisicing elit. Similique quisquam in sunt praesentium dicta debitis dignissimos?",
                'owner_id' => 1,
                'driver_id' => 1,
                'parking_id' => 1,
                'category' => "Update",
                'mobile' => "0714871033",
                'date' => Carbon::now(),
            ],

            [
                'msg' => "Unakumbushwa kuna na Lorem ipsum, dolor sit amet consectetur adipisicing elit. Similique quisquam in sunt praesentium dicta debitis dignissimos?",
                'owner_id' => 2,
                'driver_id' => 2,
                'parking_id' => 2,
                'category' => "Reminder",
                'mobile' => "0620650411",
                'date' => Carbon::now(),

            ],

        ])->each(function ($owner) {
            Alert::create($owner);
        });
    }
}
