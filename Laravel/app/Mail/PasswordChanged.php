<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $emel;
    public $title;

    /**
     * Create a new message instance.
     *
     * @param $name
     * @param $emel
     * @param $title
     */
    public function __construct($name, $emel, $title)
    {
        $this->name = $name;
        $this->emel = $emel;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.password-changed')->subject($this->title);
    }
}
