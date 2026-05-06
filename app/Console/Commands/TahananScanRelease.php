<?php

namespace App\Console\Commands;

use App\Services\TahananReleaseScanner;
use Illuminate\Console\Command;

class TahananScanRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tahanan:scan-release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan tahanan yang keluar hari ini s/d 7 hari ke depan dan buat notifikasi';

    /**
     * Execute the console command.
     */
    public function handle(TahananReleaseScanner $scanner): int
    {
        $notifikasis = $scanner->scan();

        $this->info("Notifikasi dibuat/terverifikasi: {$notifikasis->count()}");

        return self::SUCCESS;
    }
}
