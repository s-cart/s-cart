<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $view;
    public $data;
    public $config;
    public $fileAttach;
    public $fileAttachData;
    public function __construct($view, $data = array(), $config = array(), $fileAttach = array(), $fileAttachData = array())
    {
        $this->view = $view;
        $this->data = $data;
        $this->config = $config;
        $this->fileAttach = $fileAttach;
        $this->fileAttachData = $fileAttachData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->to($this->config['to']);
        if (!empty($this->config['cc'])) {
            $this->cc($this->config['cc']);
        }
        if (!empty($this->config['bbc'])) {
            $this->bbc($this->config['bbc']);
        }
        if (!empty($this->config['replyTo'])) {
            $this->replyTo($this->config['replyTo']);
        }

        if (!empty($this->config['subject'])) {
            $this->subject($this->config['subject']);
        }
        if (!empty($this->fileAttach)) {
            foreach ($this->fileAttach as $key => $attachment) {
                $this->attach($attachment);
            }

        }
        if (!empty($this->fileAttachData)) {
            foreach ($this->fileAttachData as $key => $attachmentData) {
                $this->attachData($attachmentData);
            }

        }
        return $this->view($this->view)->with($this->data);
    }
}
