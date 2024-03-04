<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuccessMangsaImport extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $title;

    /**
     * Create a new message instance.
     *
     * @param $nama
     * @param $file_name
     * @param $title
     */
    public function __construct($nama, $title)
    {
        $this->nama = $nama;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.success-mangsa-import')
        ->subject($this->title);
    }
}
