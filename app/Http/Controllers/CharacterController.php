<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CharacterController extends Controller
{
    public function index() {
        $characters = Character::all();
        return view('characters.index', compact('characters'));
    }

    public function create() {
        return view('characters.create');
    }

    public function store(Request $request) {
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
}