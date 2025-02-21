<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BulkImportContactController;

Route::get('/', [ContactController::class, 'index']);

Route::get('upload', [BulkImportContactController::class, 'upload'])->name('upload');
Route::post('import', [BulkImportContactController::class, 'import'])->name('import');

Route::resource('contacts', ContactController::class);
