<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharacterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('user/{user}', [CharacterController::class, 'userCharacters'])->name('user.characters');

Route::middleware(['auth'])->group(function () {
    // Основной CRUD (создавать может любой авторизованный)
    Route::resource('characters', CharacterController::class)->except(['index', 'show']);
    Route::post('characters/{id}/restore', [CharacterController::class, 'restore'])->name('characters.restore');
    // Восстановление (только админ)
    Route::post('characters/{id}/restore', [CharacterController::class, 'restore'])
        ->name('characters.restore');
    Route::delete('characters/{id}/force', [App\Http\Controllers\CharacterController::class, 'forceDelete'])->name('characters.forceDelete');
});

Route::get('/', [CharacterController::class, 'index'])->name('characters.index');

require __DIR__.'/auth.php';




Route::get('/', [CharacterController::class, 'index'])->name('characters.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
