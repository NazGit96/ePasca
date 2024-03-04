<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use App\Models\TabungBayaranSkb;
use App\Models\TabungBayaranSkbStatus;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetExpirySkb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:expiryskb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and set skb to expired';

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
        $expiredSkbEmel = DB::table('tbl_tabung_bayaran_skb')
        ->join('tbl_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb.id_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb_status.id')
        ->where('id_status_skb', 1)
        ->whereDate('tarikh_tamat', '=', Carbon::now()->addDays(3))
        ->select('tbl_tabung_bayaran_skb.id', 'tarikh_tamat')
        ->orderBy('tbl_tabung_bayaran_skb.id')
        ->get();

        foreach($expiredSkbEmel as $ese){
            $skb = TabungBayaranSkb::where('id', $ese->id)->first();
            $user = DB::Table('tbl_pengguna')
            ->where('id_peranan', '!=', 1)
            ->where('id_peranan', '!=', 2)
            ->where('id_peranan', '!=', 3)
            ->where('hapus', false)
            ->get();

            foreach($user as $u){
                $mail_controller = new MailController;
                $mail_controller->reminderExpiredSkb($skb->no_rujukan_skb, $skb->rujukan_surat_skb, $u->nama, $skb->tarikh_tamat, $u->emel);
            }
        }


        $expiredSkb = DB::table('tbl_tabung_bayaran_skb')
        ->join('tbl_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb.id_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb_status.id')
        ->where('id_status_skb', 1)
        ->whereDate('tarikh_tamat', '<', Carbon::now())
        ->select('tbl_tabung_bayaran_skb.id', 'tarikh_tamat')
        ->orderBy('tbl_tabung_bayaran_skb.id')
        ->get();

        foreach($expiredSkb as $es){
            $tabungSkb = TabungBayaranSkb::where('id', $es->id)->first();

            $tabungBayaranSkbStatus = TabungBayaranSkbStatus::create([
                'id_tabung_bayaran_skb' => $tabungSkb->id,
                'id_status_skb' => 2,
                'catatan' => null,
                'tarikh_cipta' => Carbon::now()
            ]);

            $tabungBayaranSkbStatus->save();

            $tabungSkb->id_tabung_bayaran_skb_status = $tabungBayaranSkbStatus->id;
            $tabungSkb->save();
        }

        $this->info('Expiry SKB job has been run.');
    }
}
