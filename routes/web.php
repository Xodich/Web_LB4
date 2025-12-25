<?php

use Illuminate\Support\Facades\Route;
// Импорт чтобы Laravel видел контроллер
use App\Http\Controllers\CharacterController;



// 2. Теперь при заходе на главную (/) вас будет перенаправлять на список персонажей
Route::get('/', function () {
    return redirect()->route('characters.index');
});

Route::resource('characters', CharacterController::class);