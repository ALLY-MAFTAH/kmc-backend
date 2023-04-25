<?php

namespace App\Services;

use App\Models\Sms;
use App\Services\SchoolService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class MailingService
{
    /**
     * Send SMS through Next SMS API
     *
     * @param array $receivers
     *
     * @return \Illuminate\Http\Client\Response|null
     */
    public function sendEmail($receiver, $subject, $body)
    {
        $from = 'amelipaapp@gmail.com';
        try {
            $mailResponse =  Mail::send('mails.index', ['receiver' => $receiver, 'body' => $body], function ($mail) use ($receiver, $subject, $from) {
                $mail->from($from, 'Smart Kinondoni');
                $mail->to($receiver->email)->subject($subject);
            });

            return $mailResponse;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
