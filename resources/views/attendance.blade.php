<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atte|日付一覧</title>
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
  <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
</head>

<body>
  <header class="header">
    <h1 class="logo">Atte</h1>
    <nav class="nav">
      <ul class="nav-wrap">
        <li class="nav-item"><a href="/" class="nav-item-link-style">ホーム</a></li>
        <li class="nav-item"><a href="/attendance" class="nav-item-link-style">日付一覧</a></li>
        <li class="nav-item"><a href="/login" class="nav-item-link-style">ログアウト</a></li>
      </ul>
    </nav>
  </header>
  <main class="attendance-list-field">
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
            <td class="table-item"></td>
            <td class="table-item"></td>
          </tr>
          @endforeach

        </tbody>
      </table>

    </div>
  </main>
  <footer class=" footer">
    <p>Atte,inc.</p>
  </footer>
  <script src=""></script>
</body>

</html>