<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/items_show.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="item-detail-body">
    <div class="item-detail-card">
        <!-- 左：商品画像 -->
<div class="image-wrapper">
    <?php if($item->sold): ?>
        <span class="sold-label">Sold</span>
    <?php endif; ?>
    <img 
        src="<?php echo e(\Illuminate\Support\Str::startsWith($item->image_path, ['http://', 'https://']) ? $item->image_path : asset('storage/' . $item->image_path)); ?>" 
        alt="<?php echo e($item->name); ?>" 
        class="item-image"
        >
</div>

        <!-- 右：商品情報 -->
        <div class="item-info">
            <h1 class="item-name"><?php echo e($item->name); ?></h1>
            <p class="item-brand">ブランド名:<?php echo e($item->brand ?? ''); ?></p>
            <p class="item-price">¥<?php echo e(number_format($item->price)); ?>（税込）</p>

            <!-- いいね & コメント数 -->
            <?php
                $isLiked = auth()->check() ? $item->isLikedBy(auth()->user()) : false;
            ?>

            <div class="item-stats">
                <!-- いいねボタン -->
                <button type="button" class="btn-like <?php echo e($isLiked ? 'liked' : ''); ?>" <?php if(auth()->check()): ?> data-item-id="<?php echo e($item->id); ?>" <?php endif; ?>>
                    <i class="<?php echo e($isLiked ? 'fas' : 'far'); ?> fa-heart"></i>
                    <span class="count"><?php echo e($item->likes->count()); ?></span>
                </button>

                <!-- コメントボタン（線アイコン） -->
                <div class="btn-comment">
                    <i class="far fa-comment"></i>
                    <span class="count"><?php echo e($item->comments->count()); ?></span>
                </div>
            </div>

            <!-- 購入ボタン -->
            <?php if(!$item->sold): ?>
                <?php if(auth()->guard()->check()): ?>
                    <form action="<?php echo e(route('purchase.create', $item->id)); ?>" method="get">
                        <button type="submit" class="btn-purchase">購入手続きへ</button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn-purchase">購入手続きへ</a>
                <?php endif; ?>
            <?php endif; ?>

            <!-- 商品説明ブロック -->
            <div class="item-block item-description-block">
                <h3>商品説明</h3>
                <p class="item-description"><?php echo e($item->description); ?></p>
            </div>

            <!-- 商品情報ブロック -->
          <!-- 商品情報ブロック -->
<div class="item-block item-info-block">
    <h3>商品の情報</h3>

  <div class="category-row">
    <h4 class="info-label">カテゴリー</h4>
    <div class="item-categories">
        <?php $__empty_1 = true; $__currentLoopData = $item->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <span class="category-label"><?php echo e($category->name); ?></span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <span class="category-label">未設定</span>
        <?php endif; ?>
    </div>
</div>
<div class="category-row">
    <h4 class="info-label">商品の状態</h4>
    <p class="item-condition"><?php echo e($item->condition); ?></p>
</div>

<!-- 商品の状態の下 -->
<div class="comments-section">

    <!-- コメント見出しとコメント数 -->
    <div class="comments-header">
        <span class="comments-label">コメント</span>
        <span class="comments-count">(<?php echo e($item->comments->count()); ?>)</span>
    </div>

    <!-- コメント一覧 -->
 <div class="comments-list">
    <?php $__empty_1 = true; $__currentLoopData = $item->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="comment-item">
            <div class="comment-header">
                <!-- 投稿者アイコン -->
                <div class="comment-icon">
                    <?php if($comment->user->profile_image_url): ?>
                        <img src="<?php echo e($comment->user->profile_image_url); ?>" alt="<?php echo e($comment->user->name); ?>">
                    <?php else: ?>
                        <div class="dummy-icon"></div>
                    <?php endif; ?>
                </div>
                <!-- 投稿者名前 -->
                <span class="comment-username"><?php echo e($comment->user->name); ?></span>
            </div>
            <!-- コメント本文 -->
            <div class="comment-body">
                <?php echo e($comment->comment); ?>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="no-comments">コメントはまだありません</p>
    <?php endif; ?>
</div>
    <!-- コメント投稿フォーム -->
    <div class="comment-post-section">
        <h4>商品へのコメント</h4>
        <form action="<?php echo e(route('items.comment', $item->id)); ?>" method="POST" class="comment-post-form">
            <?php echo csrf_field(); ?>
            <textarea name="comment" placeholder="コメントを入力"><?php echo e(old('comment')); ?></textarea>
            <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-comment-post"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <?php if(auth()->guard()->check()): ?>
                <button type="submit" class="btn-comment-post">コメントを送信</button>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn-comment-post">コメントを送信</a>
            <?php endif; ?>
        </form>
    </div>
</div>

</div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php if(auth()->guard()->check()): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-like').forEach(btn => {
        btn.addEventListener('click', function(){
            const itemId = btn.dataset.itemId;
            if(!itemId) return;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const likeCountSpan = btn.querySelector('.count');
            const icon = btn.querySelector('i');

            fetch(`/items/${itemId}/toggle-like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                if(data.liked){
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    btn.classList.add('liked');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    btn.classList.remove('liked');
                }
                likeCountSpan.textContent = data.likes_count;
            })
            .catch(err => console.error('いいね切替エラー', err));
        });
    });
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/items/show.blade.php ENDPATH**/ ?>