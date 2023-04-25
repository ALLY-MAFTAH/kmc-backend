<?php

namespace App\Jobs;

use App\Models\Business;
use App\Models\Licence;
use App\Services\MessagingService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateLicenceStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MessagingService $messagingService)
    {

        $latestLicence = [];
        $businesses = Business::all();
        $today = Carbon::now()->format("Y-m-d");
        try {

            foreach ($businesses as $business) {
                $latestLicence[] = Licence::where('business_id', $business->id)->latest()->first();
            }

            foreach ($latestLicence as $licence) {
                $end_date = Carbon::parse($licence->end_date);
                if ($end_date->lessThan($today)) {
                    $attribute['is_valid'] = 0;
                    $licence->update($attribute);
                }
            }

            return "Successfull";
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
