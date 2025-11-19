<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use UnitEnum;


class BackupList extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static UnitEnum|string|null $navigationGroup = 'Database Tools';

    protected  string $view = 'filament.pages.backup-list';
    protected static ?string $title = 'Backups';

    public function table(Table $table): Table
    {
        // we use ->records() for custom (non-eloquent) data
        return $table
            ->records(fn (?string $sortColumn = null, ?string $sortDirection = null): Collection => $this->getBackupRecords($sortColumn, $sortDirection))
            ->columns([
                TextColumn::make('name')->label('File Name')->searchable(),
                TextColumn::make('size')
                    ->label('Size')
                    ->formatStateUsing(fn ($state) => is_numeric($state) ? round($state / 1024, 2) . ' KB' : $state),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->formatStateUsing(fn ($state) => $state instanceof Carbon ? $state->toDateTimeString() : $state),
            ])
            ->actions([
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->url(fn (array $record) => route('backup.download', ['file' => $record['path']]))
                    ->openUrlInNewTab(),

                Action::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(function (array $record, $livewire) {
                        // delete file
                        Storage::disk('local')->delete($record['path']);
                    })
                    ->after(function () {
                        return redirect(request()->header('Referer'));
                    })
                    ->successNotificationTitle('Backup deleted.')

            ])
            ->bulkActions([
                BulkAction::make('delete_selected')
                    ->label('Delete selected')
                    ->action(function (Collection $records, $livewire) {
                        foreach ($records as $r) {
                            Storage::disk('local')->delete($r['path']);
                        }
                        $livewire->notify('success', 'Selected backups deleted.');
                        $livewire->emit('refreshTable');
                    })
                    ->requiresConfirmation(),
            ]);
    }

    /**
     * Build records collection for the Filament table.
     *
     * keys must be unique and consistent (they serve as record IDs).
     */
    protected function getBackupRecords(?string $sortColumn = null, ?string $sortDirection = null): Collection
    {
        $files = collect(Storage::disk('local')->files('laravel'))
            ->mapWithKeys(function (string $path) {
                $size = Storage::disk('local')->size($path);
                $ts = Storage::disk('local')->lastModified($path);

                return [
                    $path => [
                        'id' => $path,
                        'name' => basename($path),
                        'path' => $path,
                        'size' => $size,
                        'created_at' => Carbon::createFromTimestamp($ts),
                    ],
                ];
            });

        // simple sorting example (Filament will inject sort column & direction into records())
        if (filled($sortColumn)) {
            $files = $files->sortBy(
                fn ($item) => $item[$sortColumn] ?? null,
                SORT_REGULAR,
                $sortDirection === 'desc',
            );
        }

        return $files;
    }
}
