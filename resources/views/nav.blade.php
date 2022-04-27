<div id="navArea">
  <nav class="nav">
    <div class="inner">
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
    </div>
  </nav>
  <div class="toggle-btn">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <div id='mask'></div>
</div>

<style>
  @media screen and (max-width: 768px) {

    .nav-wrap {
      flex-direction: column;
    }

    .nav {
      display: block;
      width: 70%;
      position: fixed;
      background-color: white;
      top: 0;
      left: -300px;
      bottom: 0;
      transition: all 0.5s;
      z-index: 3;
      opacity: 0;
    }

    .open .nav {
      left: 0;
      opacity: 1;
    }

    .inner {
      padding: 20px;
      width: 100%;
    }

    .nav-item {
      border-bottom: 1px solid #2525e0;
    }

    .nav-item-link-style {
      display: block;
      padding: 1em 1em 0.5em 2em;
      transition-duration: 0.2s;
    }

    .toggle-btn {
      display: block;
      position: fixed;
      top: 25px;
      right: 30px;
      width: 30px;
      height: 30px;
      z-index: 3;
    }

    .open .toggle-btn {
      background-color: white;
      border-radius: 10px;
    }

    .toggle-btn span {
      position: absolute;
      display: block;
      left: 0;
      width: 30px;
      height: 2px;
      background-color: #2525e0;
      transition: all 0.5s;
      border-radius: 5px;
    }

    .toggle-btn span:nth-child(1) {
      top: 4px;
    }

    .toggle-btn span:nth-child(2) {
      top: 14px;
    }

    .toggle-btn span:nth-child(3) {
      bottom: 4px;
    }

    .open .toggle-btn span {
      background-color: #2525e0;
    }

    .open .toggle-btn span:nth-child(1) {
      transform: translateY(10px) rotate(-315deg);
    }

    .open .toggle-btn span:nth-child(2) {
      opacity: 0;
    }

    .open .toggle-btn span:nth-child(3) {
      transform: translateY(-10px) rotate(315deg);
    }

    #mask {
      display: none;
      transition: all 0.5s;
    }

    .open #mask {
      display: block;
      background-color: black;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      position: fixed;
      opacity: 0.6;
    }
  }
</style>
<script>
  let nav = document.querySelector("#navArea")
  let btn = document.querySelector(".toggle-btn")
  let mask = document.querySelector("#mask")

  btn.onclick = () => {
    nav.classList.toggle("open");
  }
  mask.onclick = () => {
    nav.classList.toggle("open");
  }
</script>