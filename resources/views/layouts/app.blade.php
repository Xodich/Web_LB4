<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персонажи игры</title>
    <!-- Подключаем CSS, который скомпилировал Laravel Mix -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <!-- NAV (Шапка) -->
    <nav class="custom-navbar">
        <div class="title_content">
            <!-- Логотип перед названием -->
            <img src="{{ asset('data/ern_logo_title.png') }}" class="icon" alt="logo">
            
            <a class="navbar-brand" href="{{ route('characters.index') }}" style="text-decoration: none;">
                <h1>ИГРОВЫЕ ПЕРСОНАЖИ</h1>
            </a>

            <!-- Кнопка "Добавить" -->
            <a href="{{ route('characters.create') }}" class="btn header-button">
                Добавить
            </a>
        </div>
    </nav>

    <!-- CONTENT WRAPPER -->
    <div class="content-wrapper">
        <!-- Твоя сетка с ограничением ширины -->
        <div class="container grid-container-override">
            @yield('content')
        </div>
    </div>

    <!-- FOOTER (Подвал) -->
    <footer class="footer">
        <div class="footer_content">
            <!-- Твоё имя или название работы -->
            <div class="footer_name">Ходаков Дмитрий. ЛР №3</div>
            
            <div class="footer_socials">
                <!-- Ссылки на соцсети с твоими классами -->
                <a href="#"><img src="{{ asset('data/ok_icon.png') }}" class="social-icon" alt="vk"></a>
                <a href="#"><img src="{{ asset('data/vk_icon.png') }}" class="social-icon" alt="vk"></a>
                <a href="#"><img src="{{ asset('data/tg_icon.png') }}" class="social-icon" alt="tg"></a>
            </div>
        </div>
    </footer>

    <!-- Подключаем JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>