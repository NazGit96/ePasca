<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use App\Models\TabungKelulusan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetExpiryKelulusan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:expirykelulusan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and set kelulusan to expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredKelulusanEmel = DB::table('tbl_tabung_kelulusan')
        ->where('status_tabung_kelulusan', 1)
        ->whereDate('tarikh_tamat_kelulusan', '=', Carbon::now()->addDays(3))
        ->select('tbl_tabung_kelulusan.id', 'tarikh_tamat_kelulusan')
        ->orderBy('tbl_tabung_kelulusan.id')
        ->get();

        foreach($expiredKelulusanEmel as $eke){
            $kelulusan = TabungKelulusan::where('id', $eke->id)->first();
            $user = DB::Table('tbl_pengguna')
            ->where('id_peranan', '!=', 1)
            ->where('id_peranan', '!=', 2)
            ->where('id_peranan', '!=', 3)
            ->where('hapus', false)
            ->get();

            foreach($user as $u){
                $mail_controller = new MailController;
                $mail_controller->reminderExpiredKelulusan($kelulusan->no_rujukan_kelulusan, $kelulusan->rujukan_surat, $u->nama, $kelulusan->tarikh_tamat_kelulusan, $u->emel);
            }
        }

        $expiredKelulusan = DB::table('tbl_tabung_kelulusan')
        ->where('status_tabung_kelulusan', 1)
        ->whereDate('tarikh_tamat_kelulusan', '<', Carbon::now())
        ->select('tbl_tabung_kelulusan.id', 'tarikh_tamat_kelulusan')
        ->orderBy('tbl_tabung_kelulusan.id')
        ->get();

        foreach($expiredKelulusan as $ek){
            $kelulusan = TabungKelulusan::where('id', $ek->id)->first();

            $kelulusan->status_tabung_kelulusan = 3;
            $kelulusan->save();
        }

        $this->info('Expiry Kelulusan job has been run.');
    }
}
