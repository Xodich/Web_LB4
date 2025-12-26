@extends('layouts.app')

@section('content')
<!-- НАВИГАЦИЯ ПО ПОЛЬЗОВАТЕЛЯМ (ЛБ №4) -->
<div class="mb-5 p-4" style="background: rgba(27, 38, 59, 0.8); border-radius: 15px; border: 1px solid #415a77;">
    <h4 class="form-title mb-3" style="font-size: 1.2rem; text-align: left;">Герои пользователей:</h4>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('characters.index') }}" class="badge {{ !isset($user) ? 'bg-primary' : 'bg-secondary' }} p-2 text-decoration-none">Все герои</a>
        @foreach($users as $u)
            <a href="{{ route('user.characters', $u->username ?? $u->id) }}" 
               class="badge {{ isset($user) && $user->id == $u->id ? 'bg-primary' : 'bg-secondary' }} p-2 text-decoration-none">
                {{ $u->username ?? $u->name }}
            </a>
        @endforeach
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="characters-grid">
    @foreach($characters as $index => $character)
    <div class="col">
        <!-- Добавляем прозрачность и ч/б фильтр, если объект удален мягко -->
        <div class="card item-card h-100 {{ $character->trashed() ? 'opacity-50' : '' }}" 
             style="{{ $character->trashed() ? 'filter: grayscale(1); border: 1px dashed #721c24;' : '' }}">
            
            <div class="teg">{{ $character->character_tag }}</div>
            
            <div class="img-container">
                @if($character->image_path)
                    <img src="{{ asset('storage/' . $character->image_path) }}" class="card-img-top" alt="{{ $character->character_name }}">
                @else
                    <img src="{{ asset('data/default.png') }}" class="card-img-top">
                @endif
            </div>

            <div class="card-body d-flex flex-column">
                <h3 class="card-title">{{ $character->character_name }}</h3>
                <p class="owner-text">Владелец: {{ $character->user->username ?? 'Система' }}</p>
                
                <p class="card-text flex-grow-1">{{ $character->short_description }}</p>
                
                <div class="btn-group-custom mt-auto">
                    <!-- Кнопка Инфо (всегда видна) -->
                    <button class="btn btn-primary btn-sm item-detail-btn" 
                            data-bs-toggle="modal" data-bs-target="#infoModal"
                            data-index="{{ $index }}"
                            data-name="{{ $character->character_name }}"
                            data-bio="{{ $character->full_biography }}"
                            data-owner="{{ $character->user->username ?? 'Система' }}"
                            data-date="{{ $character->release_date }}"
                            data-img="{{ asset('storage/' . $character->image_path) }}">
                        ИНФО
                    </button>

                    @auth
                        @if(!$character->trashed())
                            <!-- Кнопки для живых персонажей: доступны владельцу или админу -->
                            @can('update-character', $character)
                                <a href="{{ route('characters.edit', $character->id) }}" class="btn btn-card-color btn-sm">ПРАВКА</a>
                                <form action="{{ route('characters.destroy', $character->id) }}" method="POST" class="m-0">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Х</button>
                                </form>
                            @endcan
                        @else
                            <!-- КНОПКИ ДЛЯ УДАЛЕННЫХ: Видны только админу -->
                            @if(auth()->user()->is_admin)
                                <!-- Восстановление -->
                                <form action="{{ route('characters.restore', $character->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" title="Восстановить">REG</button>
                                </form>
                                <!-- Полное удаление (Расширенный уровень) -->
                                <form action="{{ route('characters.forceDelete', $character->id) }}" method="POST" class="m-0" onsubmit="return confirm('УДАЛИТЬ ИЗ БАЗЫ НАВСЕГДА?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-dark btn-sm" style="background-color: #000 !important; border: 1px solid #721c24;">
                                        DEL!
                                    </button>
                                </form>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Модальное окно -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title form-title" id="modalName"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div class="text-center mb-4">
                    <img id="modalImg" src="" class="img-fluid shadow-lg">
                </div>
                
                <div class="p-4" style="background: rgba(0,0,0,0.3); border-radius: 15px;">
                    <p class="text-warning small mb-2 text-center" id="modalOwnerDisplay" style="font-family: 'Optimus'; letter-spacing: 1px;"></p>
                    <h4 class="form-title mb-3" style="font-size: 1.3rem; text-align: left; border-bottom: 1px solid #415a77; padding-bottom: 10px;">БИОГРАФИЯ ГЕРОЯ</h4>
                    
                    <div id="modalBio" class="character-detail-text" style="font-size: 1.1rem; text-align: justify;"></div>
                    
                    <div class="mt-4 pt-3 border-top" style="border-color: #415a77 !important;">
                        <p style="color: #b0d4ff; opacity: 0.8; font-size: 0.9rem; margin-bottom: 0;" class="text-center">
                            ДАТА ПОЯВЛЕНИЯ: <span id="modalDate"></span>
                        </p>
                    </div>
                </div>

                <div class="text-center mt-3 opacity-50 text-white small">
                    Используйте стрелки ← → для переключения
                </div>
            </div>
        </div>
    </div>
</div>
@endsection