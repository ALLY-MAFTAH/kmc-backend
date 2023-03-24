<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
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
                'sticker_id' => 1,
                'vehicle_id' => 2,
                'date' => "2021-03-23",
                'amount' => 36500,
                'receipt_number' => "12345678910",
            ],
            [
                'sticker_id' => 2,
                'vehicle_id' => 2,
                'date' => "2022-03-23",
                'amount' => 36500,
                'receipt_number' => "12345678911",
            ],



        ])->each(function ($payment) {
            Payment::create($payment);
        });
    }
}
