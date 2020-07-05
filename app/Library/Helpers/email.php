<?php
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

/**
 * Function send mail
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
        Mail::send(new SendMail($view, $dataView, $emailConfig, $attach));
        // try {
        //     Mail::send(new SendMail($view, $dataView, $emailConfig, $attach));
        // } catch (\Throwable $e) {
        //     sc_report("Sendmail view:" . $view . PHP_EOL . $e->getMessage());
        // }
    } else {
        return false;
    }
}
