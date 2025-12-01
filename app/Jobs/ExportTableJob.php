<?php

namespace App\Jobs;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;

class ExportTableJob implements ShouldQueue
{
    use Queueable , SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $table;
    protected $backup;
    protected $user;
    public function __construct( $table, $backup=false , $user)
    {

        $this->table = $table;
        $this->backup = $backup;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
   public function handle()
    {
        $filename = ($this->backup ? 'BACKUP_' : '') . $this->table . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        $columns = Schema::getColumnListing($this->table);
        $records = DB::table($this->table)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        foreach ($columns as $colIndex => $name) {
            $sheet->setCellValue($this->columnLetter($colIndex + 1) . '1', $name);
        }

        // Rows
        foreach ($records as $rowIndex => $row) {
            $values = array_values((array) $row);
            foreach ($values as $colIndex => $value) {
                $sheet->setCellValue(
                    $this->columnLetter($colIndex + 1) . ($rowIndex + 2),
                    $value
                );
            }
        }

        $writer = new Xlsx($spreadsheet);

        // 📁 نحفظ مباشرة في storage/exports/
        $path = 'public/' . $filename; // ← بدون public/
        // Storage::makeDirectory('exports'); // لو غير موجود ينشئه
        $writer->save(storage_path('app/' . $path)); // ← حفظ فعلي

        Notification::make()
            ->title("Table {$this->table} exported successfully")
            ->success()
            ->body('Go to table backup list to download your file.')

            ->sendToDatabase($this->user);
    }


    private function columnLetter($c): string
    {
        $letters = '';
        while ($c > 0) {
            $p = ($c - 1) % 26;
            $c = intval(($c - $p) / 26);
            $letters = chr(65 + $p) . $letters;
        }
        return $letters;
    }
}
