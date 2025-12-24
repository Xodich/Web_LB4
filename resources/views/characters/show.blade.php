@extends('layouts.app')

@section('content')
<!-- Меняем стандартный контейнер на широкий через обертку -->
<div class="wide-container">
    <div class="card item-card p-5" style="background-color: #324361; border: none;">
        
        <h1 class="text-center mb-4 form-title" style="font-size: 3.5rem;">
            {{ $character->character_name }}
        </h1>

        <!-- Фото стало ещё больше (до 700px высотой) -->
        <div class="d-flex justify-content-center mb-5">
            @if($character->image_path)
                <img src="{{ asset('storage/' . $character->image_path) }}" 
                     class="img-fluid rounded-3 shadow-lg" 
                     style="max-height: 700px; width: auto; object-fit: contain; border: 4px solid #415a77;">
            @endif
        </div>

        <div class="character-info p-5" style="background: rgba(0,0,0,0.4); border-radius: 25px;">
            <h4 class="form-title mb-4" style="font-size: 1.8rem; border-bottom: 2px solid #415a77; padding-bottom: 15px;">
                БИОГРАФИЯ ГЕРОЯ
            </h4>
            <!-- Тот самый голубоватый цвет -->
            <div style="color: #b0d4ff; font-size: 1.4rem; text-align: justify; line-height: 1.9;">
                {!! nl2br(e($character->full_biography)) !!}
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('characters.index') }}" class="btn btn-submit-custom" style="font-size: 1.2rem; padding: 15px 50px;">
                ВЕРНУТЬСЯ К СПИСКУ
            </a>
        </div>
    </div>
</div>
@endsection