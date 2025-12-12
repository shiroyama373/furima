<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    
    <!-- 共通 CSS -->
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSRF トークン -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ページ固有 CSS -->
    @yield('css')
</head>
<body>
    <header class="site-header">
        <!-- 左：ロゴ -->
        <div class="site-logo">
            <a href="{{ route('items.index') }}">COACHTECH</a>
        </div>

        <!-- 検索フォーム + ボタン（ログイン・登録画面では非表示） -->
        @if (!Request::is('register') && !Request::is('login') && !Request::is('verify-email'))
 <div class="header-center">
    <form action="{{ route('items.index') }}" method="GET" class="search-form">
        <input type="text"
               name="keyword"
               placeholder="なにをお探しですか？"
               class="search-input"
               value="{{ request('keyword') }}">

        <!-- 🔥 今のタブを維持するために hidden を追加 -->
        <input type="hidden" name="tab" value="{{ request('tab') }}">

        <button type="submit" class="search-button">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>
</div>
            <div class="header-right">
                @guest
                    <a href="{{ route('login') }}" class="btn white-text">ログイン</a>
                    <a href="{{ route('mypage.show') }}" class="btn white-text">マイページ</a>
                    <a href="{{ route('sell.create') }}" class="btn box-white">出品</a>
                @endguest

                @auth
                    <!-- ログアウトフォーム -->
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn white-text">ログアウト</button>
                    </form>

                    <a href="{{ route('mypage.show') }}" class="btn white-text">マイページ</a>
                    <a href="{{ route('sell.create') }}" class="btn box-white">出品</a>
                @endauth
            </div>
        @endif
    </header>



    <main>
        @yield('content')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.search-form');
            if (form) { // フォームがある場合だけ実行
                form.addEventListener('submit', function(e){
                    const input = document.querySelector('.search-input');
                    if (!input.value.trim()) {
                        e.preventDefault(); // 空なら送信させない
                        alert('検索ワードを入力してください');
                    }
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>