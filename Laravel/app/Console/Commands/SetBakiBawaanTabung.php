<?php

namespace App\Console\Commands;

use App\Http\Controllers\GenerateController;
use App\Models\Tabung;
use App\Models\TabungPeruntukan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetBakiBawaanTabung extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:bakibawaantabung';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and set baki bawaan tabung';

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
        $today = Carbon::now()->toDateString();
        $year = Carbon::now()->year;

        if($today == "$year-10-17"){

            $generate = new GenerateController;
            $running_no = $generate->getBakiBawaanRunningNo();

            $allTabung = DB::table('tbl_tabung')
            ->get();

            foreach($allTabung as $at){
                $tabung = Tabung::where('id', $at->id)->first();
                $tabung->baki_bawaan = $tabung->jumlah_baki_semasa;
                $tabung->save();

                $tabungPeruntukan = TabungPeruntukan::create([
                    'id_tabung' => $tabung->id,
                    'nama_peruntukan' => "Baki Bawaan",
                    'tarikh_peruntukan' => Carbon::now(),
                    'no_rujukan' => $running_no,
                    'jumlah' => $tabung->baki_bawaan ,
                    'catatan' => null,
                    'id_jenis_peruntukan' => 3,
                    'tarikh_cipta' => Carbon::now()
                ]);

                $tabungPeruntukan->save();
            }
        }

        $this->info('Tabung job has been run.');
    }
}
