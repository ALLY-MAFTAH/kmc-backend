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

class ReminderSmsJob implements ShouldQueue
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
        $licencesToRemind = [];
        $today = Carbon::now()->addDays(31)->format('Y-m-d');

        try {
            foreach ($businesses as $business) {
                $latestLicence[] = Licence::where(['business_id' => $business->id])->latest()->first();
            }
            foreach ($latestLicence as $licence) {
                if ($licence->end_date == $today) {
                    $licencesToRemind[] = $licence;
                }
            }

            foreach ($licencesToRemind as $licence) {
                $heading =  "Habari " . $licence->business->name . "\n";
                $body =  "Leseni yako yenye namba " . $licence->number . " itaisha muda wake ndani ya siku 30 zijazo. Tafadhali fanya utaratibu wa leseni mpya kabla ya tarehe " . Carbon::parse($licence->end_date)->format('d M, Y') . "\n";
                $endTag =  'Ahsante';
                $msg = $heading . $body . $endTag;
                $messagingService->sendMessage($licence->business, $msg);
            }
            return "Successful Sent";
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
