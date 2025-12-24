@extends('layouts.app')

@section('content')
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="characters-grid">
    @foreach($characters as $index => $character)
    <div class="col">
        <div class="card item-card h-100">
            <div class="teg">{{ $character->character_tag }}</div>
            <div class="img-container">
                @if($character->image_path)
                    <img src="{{ asset('storage/' . $character->image_path) }}" class="card-img-top" alt="{{ $character->character_name }}">
                @endif
            </div>
            <div class="card-body d-flex flex-column">
                <h3 class="card-title">{{ $character->character_name }}</h3>
                <p class="card-text flex-grow-1">{{ $character->short_description }}</p>
                <div class="d-flex justify-content-center gap-1 mt-3">
                    <button class="btn btn-primary btn-sm item-detail-btn" 
                            data-bs-toggle="modal" data-bs-target="#infoModal"
                            data-index="{{ $index }}"
                            data-name="{{ $character->character_name }}"
                            data-bio="{{ $character->full_biography }}"
                            data-date="{{ $character->release_date }}" {{-- Дата передается сюда --}}
                            data-img="{{ asset('storage/' . $character->image_path) }}">
                        Детали
                    </button>
                    <a href="{{ route('characters.edit', $character->id) }}" class="btn btn-card-color btn-sm">Изменить</a>
                    <form action="{{ route('characters.destroy', $character->id) }}" method="POST" onsubmit="return confirm('Удалить героя?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">×</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Модалка -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="background-color: #324361; border: none; border-radius: 15px;">
            <div class="modal-header border-0">
                <h5 class="modal-title form-title" id="modalName" style="font-size: 2rem;"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-5">
                <div class="row align-items-center">
                    <div class="col-12 text-center mb-4">
                        <img id="modalImg" src="" class="img-fluid rounded-3 shadow-lg" style="max-height: 500px; width: auto; object-fit: contain; border: 3px solid #415a77;">
                    </div>
                    <div class="col-12">
                        <div class="p-4" style="background: rgba(0,0,0,0.3); border-radius: 15px;">
                            <h4 class="form-title mb-3" style="font-size: 1.5rem; text-align: left; border-bottom: 1px solid #415a77; padding-bottom: 10px;">БИОГРАФИЯ ГЕРОЯ</h4>
                            
                            <div id="modalBio" class="character-detail-text" style="font-size: 1.2rem; text-align: justify;"></div>

                            <!-- НОВЫЙ БЛОК С ДАТОЙ -->
                            <div class="mt-4 pt-3 border-top" style="border-color: #415a77 !important;">
                                <p style="color: #b0d4ff; opacity: 0.8; font-size: 1rem; margin-bottom: 0;">
                                    ДАТА ПОЯВЛЕНИЯ В ИГРЕ: <span id="modalDate" style="font-weight: bold;"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection