<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    // Список всех героев
    public function index() {
        $characters = Character::all();
        return view('characters.index', compact('characters'));
    }

    // Страница создания
    public function create() {
        return view('characters.create');
    }

    // Сохранение в БД
    public function store(Request $request) {
        $request->validate([
            'character_name' => 'required|max:255',
            'character_tag' => 'required',
            'short_description' => 'required|min:10',
            'full_biography' => 'required',
            'image' => 'nullable|file|max:5120', // Убрали строгий mimes, оставили просто файл до 5МБ

        ]); 

        $data = $request->all();


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'characters/' . $filename;
            
            // Делаем ресайз 400x300 (или 600x450 для качества)
            $img = Image::make($image->getRealPath());
            $img->fit(600, 450); // Это "умное" кадрирование

            Storage::disk('public')->put($path, (string) $img->encode());
            $data['image_path'] = $path;
        }

        Character::create($data);
        return redirect()->route('characters.index');
    }

    // Удаление (Soft Delete)
    public function destroy(Character $character) {
        $character->delete();
        return redirect()->route('characters.index');
    }

        public function show($id)
    {
        $character = Character::findOrFail($id);
        return view('characters.show', compact('character'));
    }

    public function update(Request $request, $id)
{
    $character = \App\Models\Character::findOrFail($id);
    
    $request->validate([
        'character_name' => 'required',
        'character_tag' => 'required',
        'short_description' => 'required',
        'full_biography' => 'required',
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $path = $request->file('image')->store('characters', 'public');
        $data['image_path'] = $path;
    }

    $character->update($data);

    return redirect()->route('characters.index')->with('success', 'Данные обновлены');
    }

    public function edit($id)
    {
        $character = \App\Models\Character::findOrFail($id);
        return view('characters.edit', compact('character'));
    }

}