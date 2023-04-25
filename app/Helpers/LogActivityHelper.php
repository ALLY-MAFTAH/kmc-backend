<?php


namespace App\Helpers;

use App\Models\ActivityLog;
use App\Models\LogActivity;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogActivityHelper
{

    public static function addToLog($subject)
    {

        $log = [];
        $log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;

        LogActivity::create($log);

    }

    public static function logActivityLists()
    {
        return LogActivity::latest()->get();
    }
}
