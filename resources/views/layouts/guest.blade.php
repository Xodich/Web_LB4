<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация - LB4</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-page">
    <div class="content-wrapper d-flex align-items-center justify-content-center" style="min-height: 100vh; padding: 20px;">
        <div class="auth-container">
            <!-- Логотип -->
            <div class="text-center mb-4">
                <a href="/">
                    <img src="{{ asset('data/ern_logo_title.png') }}" style="height: 80px;" alt="logo">
                </a>
            </div>

            <!-- Сама карточка формы -->
            <div class="card item-card p-4 shadow-lg" style="background-color: #1b263b; border: 1px solid #415a77;">
                {{ $slot }}
            </div>

            <div class="text-center mt-4">
                <a href="/" class="text-white opacity-50 small" style="text-decoration: none; font-family: 'Optimus';">
                    ← ВЕРНУТЬСЯ В ГАЛЕРЕЮ
                </a>
            </div>
        </div>
    </div>
</body>
</html>