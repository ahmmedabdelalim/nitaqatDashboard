<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Throwable;

class RunBackupJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            Log::info('Queued backup:run started');
            Artisan::call('backup:run');
            Log::info('Queued backup:run finished');
        } catch (Throwable $e) {
            Log::error('Queued backup:run failed: '.$e->getMessage());
        }
    }
}
