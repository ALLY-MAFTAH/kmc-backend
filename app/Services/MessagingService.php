<?php

namespace App\Services;

use App\Models\Sms;
use App\Services\SchoolService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MessagingService
{
    /**
     * Send SMS through Next SMS API
     *
     * @param object $receiver
     * @param string $body
     *
     * @return \Illuminate\Http\Client\Response|null
     */
    public function sendMessage($receiver, $body)
    {
        $from = 'NEXTSMS';
        $text = $body;
        $to = str_replace('+', '', $receiver->mobile);
        try {
            $messageResponse = Http::withToken(config('services.nextsms.key'), 'Basic')
                ->asJson()
                ->acceptJson()
                ->post(
                    'https://messaging-service.co.tz/api/sms/v1/text/single',
                    compact('from', 'to', 'text')
                );
            $response = $messageResponse->successful() ? 'Sent' : 'Failed';
            return $response;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
