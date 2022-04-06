@if (session('stampingMessage'))
<div class="container mt-2">
  <div class="alert alert-success">
    {{ session('stampingMessage') }}
  </div>
</div>
@endif
@if (session('error'))
<div class="container mt-2">
  <div class="alert alert-danger">
    {{ session('error') }}
  </div>
</div>
@endif