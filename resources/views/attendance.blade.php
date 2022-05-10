@extends('layout')
@section('title','Atte|日付一覧')
<header class="header">
  <h1 class="logo">Atte</h1>
  @include('nav')
</header>

@section('content')
<div class="change-date">
  <form action="/attendance" method="POST">
    @csrf
    <input type="hidden" id="date" name="date" value="{{ $today }}" class="date">
    <input type="hidden" id="before" name="before" value="before" class="before-next">
    <input type="submit" id="arrow" name="arrow" value="<" class="arrow">
  </form>
  <p class="change-date-today">{{ $today }}</p>
  <form action="/attendance" method="POST">
    @csrf
    <input type="hidden" id="date" name="date" value="{{ $today }}" class="date">
    <input type="hidden" id="next" name="next" value="next" class="before-next">
    <input type="submit" id="arrow" name="arrow" value=">" class="arrow">
  </form>
</div>
<div class="attendance-list">
  <table class="table">
    <thead class="table-head">
      <tr class="table-row">
        <th class="table-head-ttl">名前</th>
        <th class="table-head-ttl">勤務開始</th>
        <th class="table-head-ttl">勤務終了</th>
        <th class="table-head-ttl">休憩時間</th>
        <th class="table-head-ttl">勤務時間</th>
      </tr>
    </thead>
    <tbody>

      @foreach($attendances as $attendance)
      <tr class="table-row">
        <td class="table-item">{{$attendance->user->name}}</td>
        <td class="table-item">{{$attendance->start_time}}</td>
        <td class="table-item">{{$attendance->end_time}}</td>
        <td class="table-item">{{$attendance->rest_time}}</td>
        <td class="table-item">{{$attendance->work_time}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="d-flex justify-content-center">
    {{ $attendances->appends($today)->links('pagination::bootstrap-4') }}
  </div>
</div>
@endsection