@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="form-title text-center mb-4">РЕДАКТИРОВАТЬ: {{ $character->character_name }}</h2>
        
        <form action="{{ route('characters.update', $character->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label text-white">Имя героя</label>
                <input type="text" name="character_name" value="{{ old('character_name', $character->character_name) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Тег</label>
                <input type="text" name="character_tag" value="{{ old('character_tag', $character->character_tag) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Краткое описание</label>
                <textarea name="short_description" class="form-control" rows="2" required>{{ old('short_description', $character->short_description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Полная биография</label>
                <textarea name="full_biography" class="form-control" rows="5" required>{{ old('full_biography', $character->full_biography) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Дата выхода (для мутатора)</label>
                <input type="date" name="release_date" value="{{ old('release_date', $character->getRawOriginal('release_date')) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Изображение</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 mt-3">ОБНОВИТЬ ДАННЫЕ</button>
        </form>
    </div>
</div>
@endsection