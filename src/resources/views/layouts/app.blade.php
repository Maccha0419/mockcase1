<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    @yield('css')
</head>

    <body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <a href="/" class="header__logo">Atte</a>
                <nav>
                    <ul class="header-nav">
                        @if (Auth::user() && Auth::user()->hasVerifiedEmail())
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/">ホーム</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/attendance">日付一覧</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/user">ユーザー一覧</a>
                        </li>
                        <li class="header-nav__item">
                            <form class="form" action="/logout" method="post">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <p class="footer__inner">Atte, inc.</p>
    </footer>
</body>

</html>