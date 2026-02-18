<?php

use App\Http\Controllers\ArtikelController;
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
    Route::get('/news/file/thumbnail/{filename}', [BeritaController::class, 'viewFileThumbnail'])->name('admin.berita.view.thumbnail');
    Route::put('/news/edit/{slug}', [BeritaController::class, 'update'])->name('admin.berita.update');
    Route::put('/news/add/docum/{slug}', [BeritaController::class, 'addDocum'])->name('admin.berita.add.docum');
    Route::delete('/news/delete/{slug}', [BeritaController::class, 'destroy'])->name('admin.berita.destroy');
    Route::post('/news/status/{id}/toggle', [BeritaController::class, 'toggleStatus'])->name('admin.berita.toggle.status');

    // Route Artikel
    Route::get('/articles', [ArtikelController::class, 'index'])->name('admin.artikel.index');
    Route::post('/articles', [ArtikelController::class, 'store'])->name('admin.artikel.store');
    Route::get('/articles/file/{filename}', [ArtikelController::class, 'viewFile'])->name('admin.artikel.view');
    Route::put('/articles/edit/{slug}', [ArtikelController::class, 'update'])->name('admin.artikel.update');
    Route::delete('/articles/delete/{slug}', [ArtikelController::class, 'destroy'])->name('admin.artikel.destroy');
});
