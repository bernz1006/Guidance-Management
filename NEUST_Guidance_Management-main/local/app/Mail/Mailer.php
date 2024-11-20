<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $layout, $subject, $pdfPath = null, $pdfName = null)
    {
        $this->data = $data;
        $this->layout = $layout;
        $this->subject = $subject;
        $this->pdfPath = $pdfPath;
        $this->pdfName = $pdfName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->pdfPath && $this->pdfName) {
            return $this->view($this->layout)
            ->subject($this->subject)
            ->with('data', $this->data)
            ->attach($this->pdfPath, [
                'as' => $this->pdfName, // Optional: Rename the attached file
                'mime' => 'application/pdf',
            ]);
        }else{
            return $this->view($this->layout)
            ->subject($this->subject)
            ->with('data', $this->data);
        }


    }
}
