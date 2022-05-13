@extends('layout')
@section('title','Atte|従業員一覧')
<header class="header">
  <h1 class="logo">Atte</h1>
  @include('nav')
</header>
@section('content')
<div class="user-list-wrap">
  <ul class="user-lists">
    @foreach($lists as $list)
    <li class="user-list">
      <a href="/one/user/attendance/{{ $list->id }}" class="user-list-btn">
        No.{{$list->id}}&nbsp;&nbsp;&nbsp;{{ $list->name }}
      </a>
    </li>
    @endforeach
  </ul>
</div>
<div class="d-flex justify-content-center">
  {{ $lists->links('pagination::bootstrap-4') }}
</div>
@endsection