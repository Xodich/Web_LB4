<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CharacterController extends Controller
{
    public function index()
    {
        // Получаем всех героев (базовый уровень)
        $characters = Character::all(); 
        
        // Получаем всех юзеров для навигации (расширенный уровень)
        $users = \App\Models\User::all();
        return view('characters.index', compact('characters', 'users'));
    }
    public function create() {
        return view('characters.create');
    }

    public function store(Request $request)
    {
        // 1. Валидация
        $request->validate([
            'character_name' => 'required|max:255',
            'character_tag' => 'required',
            'short_description' => 'required|min:10',
            'full_biography' => 'required',
            'image' => 'nullable|file|max:5120',
        ]);

        $data = $request->all();

        // 2. ПРИВЯЗКА К ЮЗЕРУ (Важно для LB4!)
        $data['user_id'] = auth()->id(); 

        // 3. Обработка картинки
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'laravel/' . $filename;
            
            $img = \Intervention\Image\Facades\Image::make($image->getRealPath())->fit(600, 450);
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, (string) $img->encode());
            
            $data['image_path'] = $path;
        }

        // 4. Создание
        Character::create($data);

        return redirect()->route('characters.index')->with('success', 'Персонаж успешно создан!');
    }

    public function edit($id) {
        $character = Character::findOrFail($id);
        return view('characters.edit', compact('character'));
    }

    public function update(Request $request, $id) {
        $character = Character::findOrFail($id);
        
        $request->validate([
            'character_name' => 'required|max:255',
            'character_tag' => 'required',
            'short_description' => 'required|min:10',
            'full_biography' => 'required',
            'image' => 'nullable|file|max:5120',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->uploadAndResize($request->file('image'));
        }

        $character->update($data);
        return redirect()->route('characters.index')->with('success', 'Герой обновлен');
    }

    public function destroy($id) {
        Character::findOrFail($id)->delete();
        return redirect()->route('characters.index');
    }

    // Вынесенный метод для ресайза (чтобы не дублировать код)
    private function uploadAndResize($file) {
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = 'characters/' . $filename;
        
        $img = Image::make($file->getRealPath())->fit(600, 450);
        Storage::disk('public')->put($path, (string) $img->encode());
        
        return $path;
    }



    public function userCharacters(\App\Models\User $user)
    {
        $users = \App\Models\User::all();
        // Получаем персонажей этого пользователя
        $query = $user->characters();

        // Если смотрит админ или сам владелец - показываем удаленные
        if (auth()->check() && (auth()->id() === $user->id || auth()->user()->is_admin)) {
            $query->withTrashed();
        }

        $characters = $query->get();
        return view('characters.index', compact('characters', 'users'));
    }


    public function restore($id) {
        $character = Character::withTrashed()->findOrFail($id);
        if (Gate::allows('admin-only')) {
            $character->restore();
        }
        return back();
    }


}