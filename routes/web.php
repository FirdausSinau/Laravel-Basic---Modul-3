<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/activities');

Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// Harus sebelum Route::resource agar tidak tertangkap '/activities/{activity}'.
Route::get('activities/trash', [ActivityController::class, 'trash'])->name('activities.trash');

// Pakai ID karena record soft delete tidak terjangkau Route Model Binding.
Route::patch('activities/{id}/restore', [ActivityController::class, 'restore'])
    ->whereNumber('id')
    ->name('activities.restore');

Route::patch('activities/{activity}/publish', [ActivityController::class, 'publish'])->name('activities.publish');
Route::patch('activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete');
Route::resource('activities', ActivityController::class);
