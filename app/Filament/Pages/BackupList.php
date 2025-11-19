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
use Illuminate\Pagination\LengthAwarePaginator;
use UnitEnum;

class BackupList extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static UnitEnum|string|null $navigationGroup = 'Database Tools';

    protected string $view = 'filament.pages.backup-list';
    protected static ?string $title = 'Backups';

    public function table(Table $table): Table
    {
        return $table
            ->records(fn (?string $sortColumn, ?string $sortDirection) => $this->getBackupRecords($sortColumn, $sortDirection))
            ->columns([
                TextColumn::make('name')->label('File Name')->searchable(),
                TextColumn::make('size')
                    ->label('Size')
                    ->formatStateUsing(fn ($state) => is_numeric($state) ? round($state / 1024, 2) . ' KB' : $state),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->formatStateUsing(fn ($state) => $state instanceof Carbon ? $state->toDateTimeString() : $state),
            ])
            ->paginationPageOptions([5, 10, 25, 50])  // Selectable options
            ->defaultPaginationPageOption(10)         // Default per page
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
                    ->action(function (array $record) {
                        Storage::disk('local')->delete($record['path']);
                    })
                    ->after(fn () => redirect(request()->header('Referer')))
                    ->successNotificationTitle('Backup deleted.')
            ])
            ->bulkActions([
                BulkAction::make('delete_selected')
                    ->label('Delete selected')
                    ->action(function (Collection $records, $livewire) {
                        foreach ($records as $r) {
                            Storage::disk('local')->delete($r['path']);
                        }

                    })
                    ->requiresConfirmation()
                    ->after(fn () => redirect(request()->header('Referer')))
                    ->successNotificationTitle('Backup deleted.')
                    ,
            ]);
    }

    protected function getBackupRecords(?string $sortColumn, ?string $sortDirection): LengthAwarePaginator
    {
        $files = collect(Storage::disk('local')->files('Laravel'))
            ->map(fn ($path) => [
                'id'         => $path,
                'name'       => basename($path),
                'path'       => $path,
                'size'       => Storage::disk('local')->size($path),
                'created_at' => Carbon::createFromTimestamp(Storage::disk('local')->lastModified($path)),
            ]);

        if ($sortColumn) {
            $files = $files->sortBy(
                fn ($item) => $item[$sortColumn] ?? null,
                SORT_REGULAR,
                $sortDirection === 'desc',
            );
        }

        // PAGINATION HERE 🚀
        $page = $this->getTablePage();
        $perPage = $this->getTableRecordsPerPage();
        $paginated = $files->forPage($page, $perPage);

        return new LengthAwarePaginator(
            $paginated,
            $files->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );
    }
}
