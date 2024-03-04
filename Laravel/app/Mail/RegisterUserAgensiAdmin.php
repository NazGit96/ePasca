<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterUserAgensiAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $namaAdmin;
    public $namaWakil;
    public $jawatan;
    public $agensi;
    public $title;

    /**
     * Create a new message instance.
     *
     * @param $nama
     * @param $no_permohonan
     */
    public function __construct($namaAdmin, $namaWakil, $jawatan, $agensi, $title)
    {
        $this->namaAdmin = $namaAdmin;
        $this->namaWakil = $namaWakil;
        $this->jawatan = $jawatan;
        $this->agensi = $agensi;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.register-agensi-admin')->subject($this->title);
    }
}
