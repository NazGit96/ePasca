<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TidakAktifPengguna extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $emel;
    public $catatan;
    public $title;

    /**
     * Create a new message instance.
     *
     * @param $nama
     * @param $no_permohonan
     */
    public function __construct($nama, $emel, $catatan, $title)
    {
        $this->nama = $nama;
        $this->emel = $emel;
        $this->catatan = $catatan;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.deactivated-pengguna')->subject($this->title);
    }
}
