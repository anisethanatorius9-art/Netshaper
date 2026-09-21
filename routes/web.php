<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('dashboard', function () {
    return redirect('/');
})->name('dashboard');

Route::get('/speed-test-file', function () {
    $chunksize = 1024 * 1024; // 1MB
    $totalChunks = 10; // 10MB Total

    return response()->stream(function () use ($chunksize, $totalChunks) {
        for ($i = 0; $i < $totalChunks; $i++) {
            echo random_bytes($chunksize);
            flush();
        }
    }, 200, [
        'Content-Type' => 'application/octet-stream',
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
        'Content-Encoding' => 'identity',
        'X-Accel-Buffering' => 'no',
        'Expires' => '0',
    ]);
})->name('separate.file');
require __DIR__ . '/settings.php';
