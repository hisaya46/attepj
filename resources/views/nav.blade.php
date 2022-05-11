<div id="navArea">
  <nav class="nav">
    <div class="inner">
      <ul class="nav-wrap">
        <li class="nav-item"><a href="{{route('stamping')}}" class="nav-item-link-style">ホーム</a></li>
        <li class="nav-item"><a href="{{route('attendance')}}" class="nav-item-link-style">日付一覧</a></li>
        <li class="nav-item"><a href="{{route('user/list')}}" class="nav-item-link-style">ユーザー一覧</a></li>
        <li class="nav-item">
          <!-- views/layouts/navigation.blade.php から抜粋 (ログアウトボタン) -->
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-dropdown-link :href="route('logout')" class="nav-item-link-style" onclick="event.preventDefault();this.closest('form').submit();">
              {{ __('ログアウト') }}
            </x-dropdown-link>
          </form>
        </li>
      </ul>
    </div>
  </nav>
  <div class="toggle-btn">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <div id='mask'></div>
</div>