<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/blog', [ProfileController::class, 'blog'])->name('blog');
Route::post('/blog-store', [ProfileController::class, 'Store'])->name('blog.store');
Route::delete('/blog/{id}', [ProfileController::class, 'delete'])->name('blog.destroy');
Route::put('/blog/{id}', [ProfileController::class, 'updateblog'])->name('blog.update');


require __DIR__.'/auth.php';
