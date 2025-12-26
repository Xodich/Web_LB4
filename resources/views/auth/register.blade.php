<x-guest-layout>
    <h2 class="form-title mb-4">РЕГИСТРАЦИЯ</h2>

    <!-- Ошибки валидации -->
    @if ($errors->any())
        <div class="alert alert-danger mb-4" style="background: rgba(114, 28, 36, 0.5); color: #f8d7da; border: 1px solid #721c24; padding: 10px; border-radius: 5px; font-size: 0.8rem;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label class="form-label text-white">ИМЯ ПОЛЬЗОВАТЕЛЯ</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
        </div>

        <!-- Nickname (LB4 Requirement) -->
        <div class="mb-3">
            <label class="form-label text-white">НИКНЕЙМ (USERNAME)</label>
            <input type="text" name="username" value="{{ old('username') }}" class="form-control" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label text-white">ЭЛЕКТРОННАЯ ПОЧТА</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label text-white">ПАРОЛЬ</label>
            <input type="password" name="password" class="form-control" required autocomplete="new-password">
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label class="form-label text-white">ПОДТВЕРЖДЕНИЕ ПАРОЛЯ</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">
            ЗАРЕГИСТРИРОВАТЬСЯ
        </button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-white opacity-50 small" style="text-decoration: none; font-family: 'Optimus';">
                УЖЕ ЕСТЬ АККАУНТ? ВОЙТИ
            </a>
        </div>
    </form>
</x-guest-layout>