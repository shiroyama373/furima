<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/mypage_show.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="profile-container">

    <!-- 上段：写真 + 名前 + 編集ボタン -->
    <div class="profile-header">
        <div class="profile-photo">
            <img src="<?php echo e($user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default_profile.png')); ?>">
        </div>
        <div class="profile-info">
            <div class="profile-name"><?php echo e($user->name); ?></div>
            <a href="<?php echo e(route('mypage.edit')); ?>" class="profile-edit">プロフィールを編集</a>
        </div>
    </div>

    <!-- 中段：タブ -->
    <ul class="profile-tabs">
        <li class="<?php echo e($tab === 'sell' ? 'active' : ''); ?>">
            <a href="<?php echo e(route('mypage.show', ['page' => 'sell'])); ?>">出品した商品</a>
        </li>
        <li class="<?php echo e($tab === 'buy' ? 'active' : ''); ?>">
            <a href="<?php echo e(route('mypage.show', ['page' => 'buy'])); ?>">購入した商品</a>
        </li>
    </ul>

    <!-- タブ下の太い線 -->
    <hr class="tab-divider">

    <!-- 商品一覧 -->
    <div class="product-list">
        <?php
            $items = $tab === 'sell' ? $user->sellItems ?? [] : $user->purchaseItems ?? [];
        ?>

        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $imageUrl = filter_var($item->image_path, FILTER_VALIDATE_URL)
                    ? $item->image_path
                    : Storage::url($item->image_path);
            ?>
            <div class="product-card">
                <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($item->name); ?>">
                <p class="product-name"><?php echo e($item->name); ?></p>

                <?php if($item->sold): ?>
                    <span class="sold-badge">SOLD</span>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="no-items">表示する商品はありません</p>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/mypage/show.blade.php ENDPATH**/ ?>