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
    public $dataView;
    public $config;
    public $fileAttach;
    public $fileAttachData;
    public $attachFromStorage;
    public function __construct($view, $dataView = array(), $config = array(), $attach = array())
    {
        $this->view = $view;
        $this->dataView = $dataView;
        $this->config = $config;
        $this->fileAttach = $attach['fileAttach'] ?? [];
        $this->fileAttachData = $attach['fileAttachData'] ?? [];
        $this->attachFromStorage = $attach['attachFromStorage'] ?? [];
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
            //->attach('/path/to/file');

            // ->attach('/path/to/file', [
            //     'as' => 'name.pdf',
            //     'mime' => 'application/pdf',
            // ]);

            foreach ($this->fileAttach as  $attachment) {
                if(!empty($attachment['file_path'])) {
                    if(!empty($attachment['file_name'])) {
                        $this->attach($attachment['file_path'], [
                            'as' => $attachment['file_name']
                        ]);
                    } else {
                        $this->attach($attachment['file_path']);
                    }
                }
            }

        }

        if (!empty($this->attachFromStorage)) {
            //->attachFromStorageDisk('s3', '/path/to/file');

            // ->attachFromStorage('/path/to/file', 'name.pdf', [
            //     'mime' => 'application/pdf'
            // ]);
            foreach ($this->attachFromStorage as  $attachment) {
                if(!empty($attachment['file_path'])) {
                    if(!empty($attachment['file_storage'])) {
                        $this->attachFromStorageDisk($attachment['file_storage'], $attachment['file_path']);
                    } else {
                        $this->attachFromStorageDisk($attachment['file_path'], $attachment['file_name'] ?? '');
                    }
                }
            }

        }
        if (!empty($this->fileAttachData)) {
            // ->attachData($this->pdf, 'name.pdf', [
            //     'mime' => 'application/pdf',
            // ]);
            foreach ($this->fileAttachData as $k => $attachment) {
                if(!empty($attachment['file_data'])) {
                    $this->attachData($attachment['file_data'], $attachment['file_name'] ?? 'File data '.$k);
                }
            }

        }
        return $this->view($this->view)->with($this->dataView);
    }
}
