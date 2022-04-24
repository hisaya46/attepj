    <nav class="nav">
      <ul class="nav-wrap">
        <li class="nav-item"><a href="/" class="nav-item-link-style">ホーム</a></li>
        <li class="nav-item"><a href="/attendance" class="nav-item-link-style">日付一覧</a></li>
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
    </nav>