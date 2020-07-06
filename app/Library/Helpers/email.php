<?php
use App\Mail\SendMail;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Mail;

/**
 * Function send mail
 * Mail queue to run need setting crontab for php artisan schedule:run
 *
 * @param   [string]  $view            Path to view
 * @param   array     $dataView        Content send to view
 * @param   array     $emailConfig     to, cc, bbc, subject..
 * @param   array     $attach      Attach file
 *
 * @return  mixed
 */
function sc_send_mail($view, array $dataView = [], array $emailConfig = [], array $attach = [])
{
    if (!empty(sc_config('email_action_mode'))) {
        if (!empty(sc_config('email_action_queue'))) {
            dispatch(new SendEmailJob($view, $dataView,  $emailConfig, $attach));
        } else {
            sc_process_send_mail($view, $dataView,  $emailConfig, $attach);
        }
    } else {
        return false;
    }
}

/**
 * Process send mail
 *
 * @param   [type]  $view         [$view description]
 * @param   array   $dataView     [$dataView description]
 * @param   array   $emailConfig  [$emailConfig description]
 * @param   array   $attach       [$attach description]
 *
 * @return  [][][]                [return description]
 */
function sc_process_send_mail($view, array $dataView = [], array $emailConfig = [], array $attach = []) {
    try {
        Mail::send(new SendMail($view, $dataView, $emailConfig, $attach));
    } catch (\Throwable $e) {
        sc_report("Sendmail view:" . $view . PHP_EOL . $e->getMessage());
    }
}
