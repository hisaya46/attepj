@if (session('stampingMessage'))
<p class="validation"> {{ session('stampingMessage') }} </p>
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

<style>
  .validation {
    color: #d72615;
    background-color: #ffedd4;
    font-size: 1rem;
    margin: 0.5rem auto;
    padding: 0.5rem 0 0.5rem 1.5rem;
    width: 30%;
    border: solid 1px #d72615;
    border-left: solid 7px #d72615;
    border-radius: 5px;
    list-style-type: none;
  }
</style>