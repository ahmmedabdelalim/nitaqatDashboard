<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});



Route::get('/backup/download', function () {
    $file = request('file');
    return Storage::disk('local')->download($file);
})->name('backup.download');

Route::get('/backups/delete/{file}', function ($file) {
    $file = urldecode($file);
    Storage::delete($file);
    return redirect()->back()->with('success', 'Backup deleted successfully!');
});

Route::get('/download/export/{filename}', function ($filename) {
    $path = '/exports/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404, 'File not found');
    }

    return Storage::disk('public')->download($path);
})->name('download.export');
