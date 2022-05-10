@extends('layout')
@section('title','Atte|打刻')
<header class="header">
    <h1 class="logo">Atte</h1>
    @include('nav')
</header>
@section('content')
<div class="attendance">
    <h2 class="register-field-ttl">{{(Auth::user())->name}}さん、お疲れ様です！</h2>
    <div class="attendance-field">
        <form class="attendance-form" action="{{ route('timestamp/start') }}" method="POST">
            @csrf
            <div class="attendance-form-items">
                <input class="attendance-items-btn" id="workstart" type="submit" value="勤務開始" <?php if ($btn['workStart'] = false) { ?> disabled <?php }else{ ?>>
            </div>
        </form>
        <form class="attendance-form" action="{{ route('timestamp/end') }}" method="POST">
            @csrf
            <div class="attendance-form-items">
                <input class="attendance-items-btn" id="workend" type="submit" value="勤務終了" <?php if ($btn['workEnd'] = false) { ?> disabled <?php } ?>>
            </div>
        </form>
        <form class="attendance-form" action="{{ route('timestamp/breakin') }}" method="POST">
            @csrf
            <div class="attendance-form-items">
                <input class="attendance-items-btn" id="breakin" type="submit" value="休憩開始" <?php if ($btn['breakIn'] = false) { ?> disabled <?php } ?>>
            </div>
        </form>
        <form class="attendance-form" action="{{ route('timestamp/breakout') }}" method="POST">
            @csrf
            <div class="attendance-form-items attendance-form-items-last ">
                <input class="attendance-items-btn" id="breakout" type="submit" value="休憩終了" <?php if ($btn['breakOut'] = false) { ?> disabled <?php } ?>>
            </div>
        </form>
    </div>
</div>
@endsection