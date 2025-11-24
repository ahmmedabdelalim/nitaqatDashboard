<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use BackedEnum;
class DatabaseTools extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static UnitEnum|string|null $navigationGroup = 'Database Tools';
    // protected static UnitEnum|string|null $navigationGroup = 'Users';

    // MUST be non-static in Filament v4
    protected string $view = 'filament.pages.database-tools';

    public $tables = [];
    public $enableBackup = true;

    public function mount()
    {
        $hiddenTables = [
                'cache',
                'cache_locks',
                'failed_jobs',
                'job_batches',
                'jobs',
                'migrations',
                'password_reset_tokens',
                'sessions',
        ];

        $this->tables = collect(DB::select('SHOW TABLES'))
        ->map(fn ($row) => array_values((array) $row)[0])
        ->filter(fn ($table) => !in_array($table, $hiddenTables))
        ->values()
        ->toArray();
    }

    public function getTableCount($table)
    {
        return DB::table($table)->count();
    }

    public function resetTable($table)
    {
        if ($this->enableBackup) {
           return $this->exportTableExcel($table, backup: true);
        }

        DB::table($table)->truncate();

        // $this->successNotificationTitle("Table '{$table}' has been reset successfully.");

    }

    public function exportTableCsv($table): StreamedResponse
    {
        $filename = $table . '_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $columns = Schema::getColumnListing($table);
        $records = DB::table($table)->get();

        $callback = function () use ($columns, $records) {
            $output = fopen('php://output', 'w');
            fputcsv($output, $columns);

            foreach ($records as $row) {
                fputcsv($output, (array)$row);
            }

            fclose($output);
        };

        return response()->streamDownload($callback, $filename);
    }

    public function exportTableExcel($table, $backup = false)
{
    $filename = ($backup ? 'BACKUP_' : '') . $table . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

    $columns = Schema::getColumnListing($table);
    $records = DB::table($table)->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Write header row
    foreach ($columns as $colIndex => $name) {
        $sheet->setCellValue($this->columnLetter($colIndex + 1).'1', $name);
    }

    // Write data rows
    foreach ($records as $rowIndex => $row) {
        $values = array_values((array)$row);   // convert to indexed array (fixes the error)

        foreach ($values as $colIndex => $value) {
            $sheet->setCellValue(
                $this->columnLetter($colIndex + 1) . ($rowIndex + 2),
                $value
            );
        }
    }

    $writer = new Xlsx($spreadsheet);

    $tempFile = tempnam(sys_get_temp_dir(), 'xlsx');
    $writer->save($tempFile);

    return response()
        ->download($tempFile, $filename)
        ->deleteFileAfterSend(true);
}

private function columnLetter($index)
{
    $letter = '';

    while ($index > 0) {
        $remainder = ($index - 1) % 26;
        $letter = chr(65 + $remainder) . $letter;
        $index = intval(($index - $remainder) / 26);
    }

    return $letter;
}

}
