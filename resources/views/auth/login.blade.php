<x-guest-layout>
    <h2 class="form-title mb-4">ВХОД В СИСТЕМУ</h2>

    <!-- Ошибки валидации -->
    @if ($errors->any())
        <div class="alert alert-danger mb-4" style="background: rgba(114, 28, 36, 0.5); color: #f8d7da; border: 1px solid #721c24; padding: 10px; border-radius: 5px; font-size: 0.8rem;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label text-white">ЭЛЕКТРОННАЯ ПОЧТА</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label text-white">ПАРОЛЬ</label>
            <input type="password" name="password" class="form-control" required autocomplete="current-password">
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                <label for="remember_me" class="form-check-label text-white small" style="text-transform: none;">Запомнить меня</label>
            </div>
            
            @if (Route::has('password.request'))
                <a class="text-info small" href="{{ route('password.request') }}" style="text-decoration: none; font-family: 'Optimus';">
                    Забыли пароль?
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">
            ВОЙТИ
        </button>

        <div class="text-center mt-3">
            <a href="{{ route('register') }}" class="text-white opacity-50 small" style="text-decoration: none; font-family: 'Optimus';">
                НЕТ АККАУНТА? РЕГИСТРАЦИЯ
            </a>
        </div>
    </form>
</x-guest-layout>