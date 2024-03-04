<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DaftarPengguna extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $emel;
    public $title;

    /**
     * Create a new message instance.
     *
     * @param $nama
     * @param $no_permohonan
     */
    public function __construct($nama, $emel, $title)
    {
        $this->nama = $nama;
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
        return $this->markdown('email.daftar-pengguna')->subject($this->title);
    }
}