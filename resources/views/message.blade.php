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

<style>
  .validation {
    color: #d72615;
    background-color: #ffedd4;
    font-size: 1em;
    margin: 0.5em auto;
    padding: 0.5em 0 0.5em 1.5em;
    width: 30%;
    border: solid 1px #d72615;
    border-left: solid 7px #d72615;
    border-radius: 5px;
    list-style-type: none;
  }
  .stampingMessage {
    color: #2525e0;
    background-color: #f4fcff;
    border: solid 1px #2525e0;
    border-left: solid 7px #2525e0;
  }

  @media screen and (max-width: 768px) {
    .validation {
      width: 50%;
    }
  }

  @media screen and (max-width: 480px) {
    .validation {
      width: 70%;
      margin: 1em auto 0;
      font-size: 0.9em;
    }
  }
</style>