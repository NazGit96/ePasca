<?php

namespace App\Http\Controllers;

use App\Mail\DaftarUser;
use App\Mail\ForgotPassword;
use App\Mail\LulusPengguna;
use App\Mail\TolakPengguna;
use App\Mail\TidakAktifPengguna;
use App\Mail\DaftarPengguna;
use App\Mail\FailureMangsaImport;
use App\Mail\PasswordChanged;
use App\Mail\RegisterUser;
use App\Mail\RegisterUserAgensiAdmin;
use App\Mail\ReminderKelulusan;
use App\Mail\ReminderSkb;
use App\Mail\ReminderWaran;
use App\Mail\SuccessMangsaImport;
use App\Mail\TukarEmailLama;
use App\Mail\TukarEmailBaru;
use App\Mail\TukarKataLaluan;
use Illuminate\Support\Facades\Mail;

class MailController
{
    public function createUser($nama, $emel, $password){
        Mail::to($emel)->send(new DaftarUser($nama, $emel, $password, 'Pendaftaran e-Pasca Bencana'));
    }

    public function registerUser($nama, $emel){
        Mail::to($emel)->send(new RegisterUser($nama, $emel, 'Pendaftaran e-Pasca Bencana'));
    }

    public function approveUser($nama, $emel, $password){
        Mail::to($emel)->send(new LulusPengguna($nama, $emel, $password, 'Kelulusan Pengguna'));
    }

    public function tolakUser($nama, $emel, $catatan){
        Mail::to($emel)->send(new TolakPengguna($nama, $emel, $catatan, 'Penolakan Pendaftaran Pengguna'));
    }

    public function deactivatedUser($nama, $emel, $catatan){
        Mail::to($emel)->send(new TidakAktifPengguna($nama, $emel, $catatan, 'Status Pengguna Tidak Aktif'));
    }

    public function changeToBerdaftar($nama, $emel){
        Mail::to($emel)->send(new DaftarPengguna($nama, $emel, 'Pendaftaran Semula Status Pengguna'));
    }

    public function forgotPassword($nama, $emel, $reset_url){
        Mail::to($emel)->send(new ForgotPassword($nama, $emel, $reset_url, 'Tetap Semula Kata Laluan'));
    }

    public function passwordChanged($name, $emel)
    {
        Mail::to($emel)->send(new PasswordChanged($name, $emel, 'Kata Laluan Berjaya Ditukar'));
    }

    public function tukarEmelLama($nama, $emel, $changeEmel, $admin){
        Mail::to($emel)->send(new TukarEmailLama($nama, $emel, $changeEmel, $admin, 'Tetap Semula Emel & Kata Laluan'));
    }

    public function tukarEmelBaru($nama, $emel, $changeEmel, $password, $admin){
        Mail::to($changeEmel)->send(new TukarEmailBaru($nama, $emel, $changeEmel, $password, $admin, 'Tetap Semula Emel & Kata Laluan'));
    }

    public function tukarPassword($nama, $emel, $password, $admin){
        Mail::to($emel)->send(new TukarKataLaluan($nama, $emel, $password, $admin, 'Tetap Semula Kata Laluan'));
    }

    public function reminderExpiredKelulusan($noKelulusan, $rujukanSurat, $nama, $tarikhTamat, $emel){
        Mail::to($emel)->send(new ReminderKelulusan($noKelulusan, $rujukanSurat, $nama, $tarikhTamat, 'Peringatan Tamat Tempoh Kelulusan'));
    }

    public function reminderExpiredSkb($noSkb, $rujukanSurat, $nama, $tarikhTamat, $emel){
        Mail::to($emel)->send(new ReminderSkb($noSkb, $rujukanSurat, $nama, $tarikhTamat, 'Peringatan Tamat Tempoh Skb'));
    }

    public function reminderExpiredWaran($noWaran, $rujukanSurat, $nama, $tarikhTamat, $emel){
        Mail::to($emel)->send(new ReminderWaran($noWaran, $rujukanSurat, $nama, $tarikhTamat, 'Peringatan Tamat Tempoh Waran'));
    }

    public function registerAgensiAdmin($namaAdmin, $emel, $namaWakil, $jawatan, $agensi){
        Mail::to($emel)->send(new RegisterUserAgensiAdmin($namaAdmin, $namaWakil, $jawatan, $agensi, 'Permohonan Pendaftaran Agensi'));
    }

    public function failureMangsaImport($nama, $emel, $ralat, $nama_fail){
        Mail::to($emel)->send(new FailureMangsaImport($nama, $nama_fail, $ralat, 'Laporan Kemasukan Data Melalui Excel'));
    }

    public function successMangsaImport($nama, $emel){
        Mail::to($emel)->send(new SuccessMangsaImport($nama, 'Laporan Kemasukan Data Melalui Excel'));
    }
}
