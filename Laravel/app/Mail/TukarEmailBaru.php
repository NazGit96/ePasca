<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TukarEmailBaru extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $emel;
    public $changeEmel;
    public $password;
    public $admin;
    public $title;

    /**
     * Create a new message instance.
     *
     * @param $nama
     * @param $no_permohonan
     */
    public function __construct($nama, $emel, $changeEmel, $password, $admin, $title)
    {
        $this->nama = $nama;
        $this->emel = $emel;
        $this->changeEmel = $changeEmel;
        $this->password = $password;
        $this->admin = $admin;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.tukar-emel-baru')->subject($this->title);
    }
}
