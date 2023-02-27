<?php
use App\Pmo\Mail\SendMail;
use App\Pmo\Jobs\SendEmailJob;
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
if (!function_exists('sc_send_mail') && !in_array('sc_send_mail', config('helper_except', []))) {
    function sc_send_mail($view, array $dataView = [], array $emailConfig = [], array $attach = [])
    {
        if (!empty(sc_config('email_action_mode'))) {
            if (!empty(sc_config('email_action_queue'))) {
                dispatch(new SendEmailJob($view, $dataView, $emailConfig, $attach));
            } else {
                sc_process_send_mail($view, $dataView, $emailConfig, $attach);
            }
        } else {
            return false;
        }
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
if (!function_exists('sc_process_send_mail') && !in_array('sc_process_send_mail', config('helper_except', []))) {
    function sc_process_send_mail($view, array $dataView = [], array $emailConfig = [], array $attach = [])
    {
        try {
            Mail::send(new SendMail($view, $dataView, $emailConfig, $attach));
        } catch (\Throwable $e) {
            sc_report("Sendmail view:" . $view . PHP_EOL . $e->getMessage());
        }
    }
}
