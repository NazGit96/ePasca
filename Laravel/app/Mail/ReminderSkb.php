<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderSkb extends Mailable
{
    use Queueable, SerializesModels;

    public $noSkb;
    public $rujukanSurat;
    public $nama;
    public $tarikhTamat;
    public $title;

    /**
     * Create a new message instance.
     *
     * @param $nama
     * @param $no_permohonan
     */
    public function __construct($noSkb, $rujukanSurat, $nama, $tarikhTamat, $title)
    {
        $this->noSkb = $noSkb;
        $this->rujukanSurat = $rujukanSurat;
        $this->nama = $nama;
        $this->tarikhTamat = $tarikhTamat;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.reminder-expired-skb')->subject($this->title);
    }
}
