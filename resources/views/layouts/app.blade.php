<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персонажи игры - ЛР3</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav class="custom-navbar">
        <div class="title_content">
            <img src="{{ asset('data/ern_logo_title.png') }}" class="icon" alt="logo">
            <a class="navbar-brand" href="{{ route('characters.index') }}">
                <h1>ИГРОВЫЕ ПЕРСОНАЖИ</h1>
            </a>
            <a href="{{ route('characters.create') }}" class="btn header-button">Добавить</a>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="container grid-container-override">
            @yield('content')
        </div>
    </div>

    <footer class="footer">
        <div class="footer_content">
            <div class="footer_name">Ходаков Дмитрий. ЛР №3</div>
            <div class="footer_socials">
                <a href="#"><img src="{{ asset('data/ok_icon.png') }}" class="social-icon" alt="ok"></a>
                <a href="#"><img src="{{ asset('data/vk_icon.png') }}" class="social-icon" alt="vk"></a>
                <a href="#"><img src="{{ asset('data/tg_icon.png') }}" class="social-icon" alt="tg"></a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>