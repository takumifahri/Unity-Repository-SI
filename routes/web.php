<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/catalog', [CatalogController::class, 'indexAdmin'])->name('catalog.indexAdmin');
    Route::get('/catalog/create', [CatalogController::class, 'createAdmin'])->name('catalog.createAdmin');
    Route::post('/catalog/submit', [CatalogController::class, 'storeAdmin'])->name('catalog.storeAdmin');
})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('catalog')->group(function(){
    Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
});

require __DIR__.'/auth.php';
