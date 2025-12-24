@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
     
                <h2 class="form-title text-center mb-4">ДОБАВИТЬ НОВОГО ГЕРОЯ</h2>

                @if ($errors->any())
                    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; border: none; margin-bottom: 20px;">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                
                <form action="{{ route('characters.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 text-start">
                        <label class="form-label text-white">Имя героя</label>
                        <input type="text" name="character_name" value="{{ old('character_name') }}" class="form-control" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label text-white">Тег (напр. Ближний бой)</label>
                        <input type="text" name="character_tag" class="form-control" style="background: #1b263b; color: white; border: 1px solid #415a77;" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label text-white">Краткое описание</label>
                        <textarea name="short_description" class="form-control" rows="2" style="background: #1b263b; color: white; border: 1px solid #415a77;" required></textarea>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label text-white">Полная биография</label>
                        <textarea name="full_biography" class="form-control" rows="5" style="background: #1b263b; color: white; border: 1px solid #415a77;" required></textarea>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label text-white">Дата выхода (для мутатора)</label>
                        <input type="date" name="release_date" class="form-control" style="background: #1b263b; color: white; border: 1px solid #415a77;">
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label text-white">Изображение</label>
                        <input type="file" name="image" class="form-control" style="background: #1b263b; color: white; border: 1px solid #415a77;">
                    </div>

                    <button type="submit" class="btn btn-primary w-100" style="padding: 12px; font-weight: bold; text-transform: uppercase;">
                        {{ isset($character) ? 'Обновить данные' : 'Добавить персонажа' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection