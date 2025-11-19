<?php

namespace App\Console\Commands;

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

        $now = now(); // use app timezone
        $timeNow = $now->format('H:i');

        // handle frequencies
        if ($settings->frequency === 'every_minute') {
            $run = true;
        } elseif ($settings->frequency === 'every_15_minutes') {
            $run = ($now->minute % 15) === 0;
        } elseif ($settings->frequency === 'weekly') {
            $expectedDay = (int) $settings->day_of_week;
            $run = ($now->dayOfWeek === $expectedDay && $timeNow === $settings->time);
        } else { // daily
            $run = ($timeNow === $settings->time);
        }

        if ($run) {
            Log::info('Configured backup starting at '.$now);
            try {
               Artisan::call('backup:run');
                Log::info('Configured backup finished at '.now());
                $this->info('Backup completed.');
            } catch (\Throwable $e) {
                Log::error('Configured backup failed: '.$e->getMessage());
                $this->error('Backup failed: '.$e->getMessage());
            }
        } else {
            $this->info('No backup scheduled at '.$timeNow);
        }

        return 0;
    }
}
