<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    
    <!-- 共通 CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/common.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSRF トークン -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- ページ固有 CSS -->
    <?php echo $__env->yieldContent('css'); ?>
</head>
<body>
    <header class="site-header">
        <!-- 左：ロゴ -->
        <div class="site-logo">
            <a href="<?php echo e(route('items.index')); ?>">COACHTECH</a>
        </div>

        <!-- 検索フォーム + ボタン（ログイン・登録画面では非表示） -->
        <?php if(!Request::is('register') && !Request::is('login') && !Request::is('verify-email')): ?>
 <div class="header-center">
    <form action="<?php echo e(route('items.index')); ?>" method="GET" class="search-form">
        <input type="text"
               name="keyword"
               placeholder="なにをお探しですか？"
               class="search-input"
               value="<?php echo e(request('keyword')); ?>">

        <!-- 🔥 今のタブを維持するために hidden を追加 -->
        <input type="hidden" name="tab" value="<?php echo e(request('tab')); ?>">

        <button type="submit" class="search-button">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>
</div>
            <div class="header-right">
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn white-text">ログイン</a>
                    <a href="<?php echo e(route('mypage.show')); ?>" class="btn white-text">マイページ</a>
                    <a href="<?php echo e(route('sell.create')); ?>" class="btn box-white">出品</a>
                <?php endif; ?>

                <?php if(auth()->guard()->check()): ?>
                    <!-- ログアウトフォーム -->
                    <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn white-text">ログアウト</button>
                    </form>

                    <a href="<?php echo e(route('mypage.show')); ?>" class="btn white-text">マイページ</a>
                    <a href="<?php echo e(route('sell.create')); ?>" class="btn box-white">出品</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </header>



    <main>
        <?php echo $__env->yieldContent('content'); ?>
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

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH /var/www/resources/views/layouts/app.blade.php ENDPATH**/ ?>