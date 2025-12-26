<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ИГРОВЫЕ ПЕРСОНАЖИ - LB4</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <!-- NAV (Шапка в твоем стиле) -->
    <nav class="custom-navbar">
        <div class="title_content">
            <!-- Твой логотип -->
            <div class="d-flex align-items-center">
                <img src="{{ asset('data/ern_logo_title.png') }}" class="icon" alt="logo">
                <a class="navbar-brand" href="{{ route('characters.index') }}" style="text-decoration: none;">
                    <h1>ИГРОВЫЕ ПЕРСОНАЖИ</h1>
                </a>
            </div>

            <!-- БЛОК АВТОРИЗАЦИИ (Логика Breeze) -->
            <div class="auth-links d-flex align-items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <!-- Если пользователь вошел -->
                        <span class="text-white small me-3" style="font-family: 'Optimus';">
                            {{ Auth::user()->name }} 
                            @if(Auth::user()->is_admin) <span class="text-warning">(Admin)</span> @endif
                        </span>
                        
                        <!-- Кнопка добавить доступна только авторизованным (требование LB4) -->
                        <a href="{{ route('characters.create') }}" class="btn header-button btn-sm">Добавить</a>

                        <!-- Кнопка Выход (обязательно через форму POST) -->
                        <form method="POST" action="{{ route('logout') }}" class="m-0 ms-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm" style="font-family: 'Optimus';">
                                ВЫЙТИ
                            </button>
                        </form>
                    @else
                        <!-- Если гость -->
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm" style="font-family: 'Optimus';">ВОЙТИ</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-info btn-sm" style="font-family: 'Optimus';">РЕГИСТРАЦИЯ</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- ОСНОВНОЙ КОНТЕНТ -->
    <div class="content-wrapper">
        <div class="container grid-container-override">
            <!-- Здесь будет выводиться твой characters.index -->
            @yield('content')
            
            <!-- Если Breeze будет использовать стандартные страницы, они используют $slot -->
            @if(isset($slot))
                {{ $slot }}
            @endif
        </div>
    </div>

    <!-- ПОДВАЛ -->
    <footer class="footer">
        <div class="footer_content">
            <div class="footer_name">Ходаков Дмитрий. ЛР №4</div>
            <div class="footer_socials">
                <a href="#"><img src="{{ asset('data/ok_icon.png') }}" class="social-icon" alt="ok"></a>
                <a href="#"><img src="{{ asset('data/vk_icon.png') }}" class="social-icon" alt="vk"></a>
                <a href="#"><img src="{{ asset('data/tg_icon.png') }}" class="social-icon" alt="tg"></a>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>