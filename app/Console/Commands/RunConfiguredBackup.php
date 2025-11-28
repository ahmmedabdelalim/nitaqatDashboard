<?php

namespace App\Console\Commands;

use App\Jobs\RunBackupJob;
use App\Models\BackupSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class RunConfiguredBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:run-configured';
    protected $description = 'Run backup if the configured time/frequency matches now';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settings = BackupSetting::first();
        if (! $settings || ! $settings->enabled) {
            $this->info('Backups disabled or not configured.');
            return 0;
        }

        $now = now();
        $timeNow = $now->format('H:i');

        if ($settings->frequency === 'every_minute') {
            $run = true;
        } elseif ($settings->frequency === 'every_15_minutes') {
            $run = ($now->minute % 15) === 0;
        } elseif ($settings->frequency === 'weekly') {
            $run = ($now->dayOfWeek === (int)$settings->day_of_week && $timeNow === $settings->time);
        } else { // daily
            $run = ($timeNow === $settings->time);
        }

        if (! $run) {
            $this->info('No backup scheduled for '.$timeNow);
            return 0;
        }
        // 🚀 Dispatch as Queue (background)
        RunBackupJob::dispatch();

        Log::info('Backup dispatched to queue at '.$now);
        $this->info('Backup queued successfully.');

        return 0;
    }
}
