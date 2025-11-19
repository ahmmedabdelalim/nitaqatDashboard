<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Notifications\Notification;
use App\Models\BackupSetting;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Artisan;
use UnitEnum;
class BackupSettings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    // protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static UnitEnum|string|null $navigationGroup = 'Database Tools';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected  string $view = 'filament.pages.backup-settings';
    protected static ?string $navigationLabel = 'Backup Settings';

    public $enabled;
    public $time;
    public $frequency;
    public $day_of_week;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Toggle::make('enabled')->label('Enable backups'),
            Forms\Components\TextInput::make('time')
                ->label('Backup Time (HH:MM)')
                ->required()
                ->placeholder('02:00')
                ->rules(['regex:/^(?:[01]\d|2[0-3]):[0-5]\d$/']), // HH:MM validation
            Forms\Components\Select::make('frequency')
                ->label('Frequency')
                ->options([
                    'daily' => 'Daily',
                    'weekly' => 'Weekly',
                    'every_15_minutes' => 'Every 15 minutes',
                    'every_minute' => 'Every minute',
                ])
                ->required(),
            Forms\Components\Select::make('day_of_week')
                ->label('Day (for weekly)')
                ->options([
                    0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
                    4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'
                ])
                ->hidden(fn ($get) => $get('frequency') !== 'weekly'),
        ];
    }

    public function mount(): void
    {
        $settings = BackupSetting::first();
        if ($settings) {
            $this->form->fill([
                'enabled' => $settings->enabled,
                'time' => $settings->time,
                'frequency' => $settings->frequency,
                'day_of_week' => $settings->day_of_week,
            ]);
        }
    }

    public function save()
    {
        $data = $this->form->getState();
        BackupSetting::updateOrCreate(['id' => 1], $data);

        Notification::make()->title('Backup settings saved')->success()->send();
    }

    public function backupNow()
    {
        // Run backup job (Spatie)
        Artisan::call('backup:run');
        Notification::make()->title('Backup completed')->success()->send();
    }
}
