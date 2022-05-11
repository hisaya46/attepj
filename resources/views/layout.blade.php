<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/atte/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/atte/register.css') }}">
  <link rel="stylesheet" href="{{ asset('css/atte/index.css') }}">
  <link rel="stylesheet" href="{{ asset('css/atte/stamping.css') }}">
  <link rel="stylesheet" href="{{ asset('css/atte/user.css') }}">
</head>

<body>
  @include('message')
  <main class="register-field">
    @yield('content')
  </main>
  <footer class="footer">
    @include('footer')
  </footer>
  <script src="{{ asset('js/toggle.js') }}"></script>
</body>

</html>