<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $view;
    public $dataView;
    public $emailConfig;
    public $attach;
    public function __construct($view, array $dataView = [], array $emailConfig = [], array $attach = [])
    {
        $this->view = $view;
        $this->dataView = $dataView;
        $this->emailConfig = $emailConfig;
        $this->attach = $attach;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sc_process_send_mail($this->view, $this->dataView, $this->emailConfig, $this->attach);
    }
}
