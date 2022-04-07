<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte|打刻</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    <header class="header">
        <h1 class="logo">Atte</h1>
        <nav class="nav">
            <ul class="nav-wrap">
                <li class="nav-item"><a href="/" class="nav-item-link-style">ホーム</a></li>
                <li class="nav-item"><a href="/attendance" class="nav-item-link-style">日付一覧</a></li>
                <li class="nav-item">
                    <!-- views/layouts/navigation.blade.php から抜粋 (ログアウトボタン) -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" class="nav-item-link-style" onclick="event.preventDefault();this.closest('form').submit();">
                            {{ __('ログアウト') }}
                        </x-dropdown-link>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main class="register-field">
        @include('message')
        <div class="attendance">
            <h2 class="register-field-ttl">{{(Auth::user())->name}}さんお疲れ様です！</h2>
            <div class="attendance-field">
                <form class="attendance-form" action="{{ route('timestamp/start') }}" method="POST">
                    @csrf
                    <div class="attendance-form-items">
                        <input class="attendance-items-btn" type="submit" value="勤務開始">
                    </div>
                </form>
                <form class="attendance-form" action="{{ route('timestamp/end') }}" method="POST">
                    @csrf
                    <div class="attendance-form-items">
                        <input class="attendance-items-btn" type="submit" value="勤務終了" disabled>
                    </div>
                </form>
                <form class="attendance-form" action="{{ route('timestamp/breakin') }}" method="POST">
                    @csrf
                    <div class="attendance-form-items">
                        <input class="attendance-items-btn" id="breakin" type="submit" value="休憩開始" disabled>
                    </div>
                </form>
                <form class="attendance-form" action="{{ route('timestamp/breakout') }}" method="POST">
                    @csrf
                    <div class="attendance-form-items">
                        <input class="attendance-items-btn" id="breakout" type="submit" value="休憩終了">
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="footer">
        <p>Atte,inc.</p>
    </footer>
    <script>
        // function breakin() {
        //     document.getElementById("breakin").disabled = true;
        //     document.getElementById("breakout").disabled = false;
        // }

        // function breakout() {
        //     document.getElementById("breakin").disabled = false;
        //     document.getElementById("breakout").disabled = true;
        // }
    </script>
</body>

</html>