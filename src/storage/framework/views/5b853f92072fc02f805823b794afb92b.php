<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/index.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
    // 🔥 ログインしていればマイリスト、ゲストはおすすめを初期表示
    $defaultTab = auth()->check() ? 'mylist' : 'recommend';
    $currentTab = request('tab', $defaultTab);
?>

<div class="items-body">

    <!-- おすすめ / マイリストタブ -->
    <div class="tabs">
        <a href="<?php echo e(route('items.index', ['tab' => 'recommend'])); ?>"
           class="tab <?php echo e($currentTab === 'recommend' ? 'active' : ''); ?>">
            おすすめ
        </a>

        <a href="<?php echo e(route('items.index', ['tab' => 'mylist'])); ?>"
           class="tab <?php echo e($currentTab === 'mylist' ? 'active' : ''); ?>">
            マイリスト
        </a>
    </div>

    <!-- 下にグレーの線 -->
    <hr class="tab-underline">

    <!-- 商品一覧 -->
    <div class="items-list">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $imageUrl = \Illuminate\Support\Str::startsWith($item->image_path, ['http://','https://'])
                    ? $item->image_path
                    : asset('storage/' . $item->image_path);
            ?>

            <div class="item-card">
                <div class="image-wrapper">
                    <?php if($item->sold): ?>
                        <span class="sold-label">Sold</span>
                    <?php endif; ?>

                    <a href="<?php echo e(route('items.show', $item->id)); ?>">
                        <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($item->name); ?>" class="item-image">
                    </a>
                </div>

                <h3 class="item-name"><?php echo e($item->name); ?></h3>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/items/index.blade.php ENDPATH**/ ?>