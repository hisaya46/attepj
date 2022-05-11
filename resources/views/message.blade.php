@if (session('stampingMessage'))
<p class="validation stampingMessage"> {{ session('stampingMessage') }} </p>
@endif

@if (session('error'))
<p class="validation"> {{ session('error') }} </p>
@endif

@if (count($errors) > 0)
<ul>
  @foreach ($errors->all() as $error)
  <li class="validation"> {{$error}} </li>
  @endforeach
</ul>
@endif

@if (session('login_error'))
<p class="validation"> {{session('login_error')}} </p>
@endif