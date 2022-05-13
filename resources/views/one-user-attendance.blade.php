@extends('layout')
@section('title','Atte|従業員別勤怠表')
<header class="header">
  <h1 class="logo">Atte</h1>
  @include('nav')
</header>

@section('content')
<div class="user-records">
  <h2 class="register-field-ttl">{{ $name->name }}さんの勤怠表</h2>
  <div class="change-date">
    <form action="/one/user/attendance/{{ $lists->id }}" method="POST">
      @csrf
      <input type="hidden" id="date" name="date" value="{{ $date }}" class="date">
      <input type="hidden" id="before" name="before" value="before" class="before-next">
      <input type="submit" id="arrow" name="arrow" value="<" class="arrow">
    </form>
    <p class="change-date-today">{{ $date }}</p>
    <form action="/one/user/attendance/{{ $lists->id }}" method="POST">
      @csrf
      <input type="hidden" id="date" name="date" value="{{ $date }}" class="date">
      <input type="hidden" id="next" name="next" value="next" class="before-next">
      <input type="submit" id="arrow" name="arrow" value=">" class="arrow">
    </form>
  </div>
  <div class="attendance-list">
    <table class="table">
      <thead class="table-head">
        <tr class="table-row">
          <th class="table-head-ttl">日付</th>
          <th class="table-head-ttl">勤務開始</th>
          <th class="table-head-ttl">勤務終了</th>
          <th class="table-head-ttl">休憩時間</th>
          <th class="table-head-ttl">勤務時間</th>
        </tr>
      </thead>
      <tbody>

        @foreach($attendances as $attendance)
        <tr class="table-row">
          <td class="table-item">{{$attendance->date}}</td>
          <td class="table-item">{{$attendance->start_time}}</td>
          <td class="table-item">{{$attendance->end_time}}</td>
          <td class="table-item">{{$attendance->rest_time}}</td>
          <td class="table-item">{{$attendance->work_time}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection