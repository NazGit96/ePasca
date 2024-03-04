<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $emel;
    public $reset_url;
    public $title;

    /**
     * Create a new message instance.
     *
     * @param $nama
     * @param $emel
     * @param $reset_url
     * @param $title
     */
    public function __construct($nama, $emel, $reset_url, $title)
    {
        $this->nama = $nama;
        $this->emel = $emel;
        $this->reset_url = $reset_url;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.forgot-password')->subject($this->title);
    }
}
