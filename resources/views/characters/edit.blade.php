@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h2 class="form-title text-center mb-4">РЕДАКТИРОВАТЬ: {{ $character->character_name }}</h2>
            
            <form action="{{ route('characters.update', $character->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Обязательно для обновления -->
                
                <div class="mb-3 text-start">
                    <label class="form-label text-white">Имя героя</label>
                    <input type="text" name="character_name" value="{{ $character->character_name }}" class="form-control" required>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label text-white">Тег</label>
                    <input type="text" name="character_tag" value="{{ $character->character_tag }}" class="form-control" required>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label text-white">Краткое описание</label>
                    <textarea name="short_description" class="form-control" rows="2" required>{{ $character->short_description }}</textarea>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label text-white">Полная биография</label>
                    <textarea name="full_biography" class="form-control" rows="5" required>{{ $character->full_biography }}</textarea>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label text-white">Изображение (оставьте пустым, если не хотите менять)</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary w-100" style="padding: 12px; font-weight: bold; text-transform: uppercase;">
                    {{ isset($character) ? 'Обновить данные' : 'Добавить персонажа' }}
                </button>
            </form>

            </div>
        </div>
    </div>
@endsection