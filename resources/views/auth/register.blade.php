@extends('layout')
@section('title','Atte|会員登録')
<header class="header">
    <h1 class="logo">Atte</h1>
</header>
@section('content')
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
@endsection