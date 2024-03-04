<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TrimTempFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trim:tempfolder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove files in temporary folder that more than 24hours.';

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
        collect(Storage::disk('public')->listContents('temp', true))
        ->each(function($file) {
            if ($file['type'] == 'file' && $file['timestamp'] < now()->subDays(1)->getTimestamp()) {
                Storage::disk('public')->delete($file['path']);
            }
        });
        $this->info('Files with more than one day age has been deleted.');
    }
}
