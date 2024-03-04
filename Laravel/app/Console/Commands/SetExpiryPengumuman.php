<?php

namespace App\Console\Commands;

use App\Models\RefPengumuman;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetExpiryPengumuman extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:expirypengumuman';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and set pengumuman to expired';

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
        $expiredPengumuman = DB::table('ref_pengumuman')
        ->where('status_pengumuman', 1)
        ->whereDate('tarikh_tamat', '<', Carbon::now())
        ->select('ref_pengumuman.id', 'tarikh_tamat')
        ->orderBy('ref_pengumuman.id')
        ->get();

        foreach($expiredPengumuman as $ep){
            $pengumuman = RefPengumuman::where('id', $ep->id)->first();
            $pengumuman->status_pengumuman = 2;
            $pengumuman->save();
        }


        $this->info('Expiry Pengumuman job has been run.');
    }
}
