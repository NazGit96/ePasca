<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FailureMangsaImport extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $file_path;
    public $error;
    public $title;

    /**
     * Create a new message instance.
     *
     * @param $nama
     * @param $file_name
     * @param $title
     */
    public function __construct($nama, $file_name, $error, $title)
    {
        $this->nama = $nama;
        $this->file_name = $file_name;
        $this->error = $error;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.failure-mangsa-import')
        ->attach(storage_path('app/public/excel/errors/'.$this->file_name), ['as' => $this->file_name, 'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
        ->subject($this->title);
    }
}
