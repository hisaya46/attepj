<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte|会員登録</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <header class="header">
        <h1 class="logo">Atte</h1>
    </header>
    <main class="register-field">
        @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
            <li>
                {{$error}}
            </li>
            @endforeach
        </ul>
        @endif
        <div class="register-field-content">
            <h2 class="register-field-ttl">会員登録</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <ul class="register-field-lists">
                    <li class="register-field-list"><input class="register-item" type="text" name="name" id="name" placeholder="名前"></li>
                    <li class="register-field-list"><input class="register-item" type="email" name="email" id="email" placeholder="メールアドレス"></li>
                    <li class="register-field-list"><input class="register-item" type="password" name="password" id="password" placeholder="パスワード"></li>
                    <li class="register-field-list"><input class="register-item" type="password" name="password_confirmation" id="password_confirmation" placeholder="確認用パスワード" oninput="CheckPassword(this)"></li>
                    <li class="register-field-list"><input class="register-item register-btn" type="submit" value="会員登録"></li>
                </ul>
            </form>
            <div class="register-field-login">
                <p class="register-field-login-message">アカウントをお持ちの方はこちらから</p>
                <a href="/login" class="register-field-login-btn">ログイン</a>
            </div>
        </div>
    </main>
    <footer class="footer">
        <p>Atte,inc.</p>
    </footer>
    <script src="{{ asset('js/register.js') }}"></script>
</body>

</html>