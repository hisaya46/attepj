@extends('layout')
@section('title','Atte|日付一覧')
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



<style>
  .user-list-wrap {
    width: 85%;
    margin: 3em auto;
  }

  .user-lists {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    padding: 0;
  }

  .user-list {
    width: calc(97.7% / 5);
    list-style-type: none;
    padding: 0;
  }

  .user-list-btn {
    display: block;
    width: 100%;
    padding: 10px;
    text-align: left;
    border: 1px solid #2525e0;
    background-color: #fff;
    color: #333;
    opacity: 1;
    text-decoration: none;
  }

  .user-list-btn:hover {
    opacity: 0.7;
  }
</style>