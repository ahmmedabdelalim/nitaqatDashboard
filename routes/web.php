<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});


// Route::get('/backups/download/{file}', function ($file) {
//     $file = urldecode($file);
//     return Storage::download($file);
// });

Route::get('/backup/download', function () {
    $file = request('file');
    return Storage::disk('local')->download($file);
})->name('backup.download');

Route::get('/backups/delete/{file}', function ($file) {
    $file = urldecode($file);
    Storage::delete($file);
    return redirect()->back()->with('success', 'Backup deleted successfully!');
});

