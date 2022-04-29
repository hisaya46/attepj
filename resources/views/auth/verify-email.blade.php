@extends('layout')
@section('title','Atte|Thanks')
<header class="header">
    <h1 class="logo">Atte</h1>
</header>
@section('content')
<div class="thanks-message">
    <div class="">
        <p>会員登録ありがとうございます！<br><br>本人確認のため、ご入力いただいたメールアドレス宛に、確認用リンクを送信しましたのでご確認ください！<br><br>
            ※メールが届かない場合は、入力したアドレスに間違いがあるか、あるいは迷惑メールフォルダに入っている可能性がありますのでご確認ください。<br><br>確認用メールを再送する場合は再送信ボタンをクリックしてください。</p>
    </div>

    @if (session('status') == 'verification-link-sent')
    <div class="">
        登録時に入力いただいたメールアドレスに新しい確認用リンクが送信されました。
    </div>
    @endif

    <div class="">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div class="btn-wrap">
                <button class="re-btn">
                    {{ __('再送信') }}
                </button>
            </div>
        </form>
        <div class="back">
            <div class="register-field-login">
                <p class="register-field-login-message">会員登録画面へ戻る場合は</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('register')" class="register-field-login-btn" onclick="event.preventDefault();this.closest('form').submit();">
                        {{ __('こちら') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    .thanks-message {
        width: 50%;
        margin: 50px auto;
        font-size: 1.2em;
        font-weight: bold;
    }

    .btn-wrap {
        width: 100%;
    }

    .re-btn {
        display: block;
        background-color: beige;
        color: #2525e0;
        border: 1px solid #2525e0;
        border-radius: 5px;
        padding: 5px 10px;
        margin: 0 auto;
    }

    .back {
        margin-top: 50px;
    }
</style>