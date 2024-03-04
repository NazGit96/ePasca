<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DaftarUser extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $emel;
    public $password;
    public $title;

    /**
     * Create a new message instance.
     *
     * @param $nama
     * @param $no_permohonan
     */
    public function __construct($nama, $emel, $password, $title)
    {
        $this->nama = $nama;
        $this->emel = $emel;
        $this->password = $password;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.daftar-user')->subject($this->title);
    }
}
