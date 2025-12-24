<?php

use Illuminate\Support\Facades\Route;
// 1. Обязательно добавьте этот импорт, чтобы Laravel знал, где искать ваш контроллер
use App\Http\Controllers\CharacterController;



// 2. Теперь при заходе на главную (/) вас будет перенаправлять на список персонажей
Route::get('/', function () {
    return redirect()->route('characters.index');
});

Route::resource('characters', CharacterController::class);