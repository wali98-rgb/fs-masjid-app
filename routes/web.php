<?php

use App\Http\Controllers\BeritaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.index');
});

Route::prefix('cms-admin')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin.dashboard');

    // Route Berita
    Route::get('/news', [BeritaController::class, 'index'])->name('admin.berita.index');
    Route::post('/news', [BeritaController::class, 'store'])->name('admin.berita.store');
    Route::get('/news/file/{filename}', [BeritaController::class, 'viewFile'])->name('admin.berita.view');
});
