<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CharacterController extends Controller
{
    public function index()
    {
        $users = User::all();

        if (auth()->check() && auth()->user()->is_admin) {
            $characters = Character::withTrashed()->get();
        } else {
            $characters = Character::all();
        }
        
        return view('characters.index', compact('characters', 'users'));
    }

    public function create() {
        return view('characters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'character_name' => 'required|max:255',
            'character_tag' => 'required',
            'short_description' => 'required|min:10',
            'full_biography' => 'required',
            'image' => 'nullable|file|max:5120',
        ]);

        $data = $request->all();

        // Автоматически привязываем персонажа к ID текущего авторизованного пользователя
        $data['user_id'] = auth()->id(); 

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->uploadAndResize($request->file('image'));
        }

        Character::create($data);

        return redirect()->route('characters.index');
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
        return redirect()->route('characters.index');
    }

    // Мягкое удаление
    public function destroy($id) {
        Character::findOrFail($id)->delete();
        return redirect()->route('characters.index');
    }

    // Вспомогательный метод: сохраняет фото в папку laravel и меняет его размер под параметры верстки
    private function uploadAndResize($file) {
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = 'laravel/' . $filename;

        $img = Image::make($file->getRealPath())->fit(600, 450);
        Storage::disk('public')->put($path, (string) $img->encode());
        
        return $path;
    }

    // Вывод списка персонажей, принадлежащих конкретному пользователю (поиск идет по никнейму в URL)
    public function userCharacters(User $user)
    {
        $users = User::all();
        $query = $user->characters();

        // Если страницу своего профиля смотрит владелец или администратор показываем и удаленные карточки
        if (auth()->check() && (auth()->id() === $user->id || auth()->user()->is_admin)) {
            $query->withTrashed();
        }

        $characters = $query->get();
        return view('characters.index', compact('characters', 'users', 'user'));
    }

    public function restore($id)
    {
        $character = Character::withTrashed()->findOrFail($id);
        
        if (auth()->user()->is_admin) {
            $character->restore();
            return back();
        }

        abort(403, 'Только администратор может восстанавливать объекты');
    }

    // Окончательное удаление
    public function forceDelete($id)
    {
        $character = Character::withTrashed()->findOrFail($id);

        if (auth()->user()->is_admin) {
            $character->forceDelete(); 
            return back();
        }

        abort(403, 'Только администратор может удалять данные безвозвратно');
    }
}