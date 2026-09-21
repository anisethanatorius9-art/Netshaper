<?php

use Illuminate\Support\Facades\Route;

Route::get('settings', function () {
    return redirect('/');
});

Route::get('settings/profile', function () {
    return redirect('/');
});

Route::get('settings/appearance', function () {
    return redirect('/');
});

Route::get('settings/security', function () {
    return redirect('/');
});

Route::get('.well-known/passkey-endpoints', function () {
    return response()->json([
        'enroll' => '/',
        'manage' => '/',
    ]);
})->name('well-known.passkeys');
