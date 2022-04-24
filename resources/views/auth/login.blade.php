@extends('layout')
@section('title','Atte|ログイン')
<header class="header">
    <h1 class="logo">Atte</h1>
</header>
@section('content')
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
@endsection