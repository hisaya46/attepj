<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte|ログイン</title>
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
            <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif

        @if (session('login_error'))
        <p>{{session('login_error')}}</p>
        @endif
        <div class="register-field-content">
            <h2 class="register-field-ttl">ログイン</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <ul class="register-field-lists">
                    <li class="register-field-list"><input class="register-item" type="email" name="email" id="email" placeholder="メールアドレス"></li>
                    <li class="register-field-list"><input class="register-item" type="password" name="password" id="password" placeholder="パスワード"></li>
                    <li class="register-field-list"><input class="register-item register-btn" type="submit" value="ログイン"></li>
                </ul>
            </form>
            <div class="register-field-login">
                <p class="register-field-login-message">アカウントをお持ちでない方はこちらから</p>
                <a href="/register" class="register-field-login-btn">会員登録</a>
            </div>
        </div>
    </main>
    <footer class="footer">
        <p>Atte,inc.</p>
    </footer>
    <script src="{{ asset('js/register.js') }}"></script>
</body>

</html>