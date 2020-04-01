<?php
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

function sc_send_mail($view, $data = [], $config = [], $fileAttach = [], $fileAttachData = [])
{
    if (!empty(sc_config('email_action_mode'))) {
        try {
            Mail::send(new SendMail($view, $data, $config, $fileAttach, $fileAttachData));
        } catch (\Exception $e) {
            sc_report("Sendmail view:" . $view . PHP_EOL . $e->getMessage());
        }

    } else {
        return false;
    }
}
