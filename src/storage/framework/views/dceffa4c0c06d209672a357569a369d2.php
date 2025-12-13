<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/purchase_complete.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="purchase-complete-container">
    <h2>購入が完了しました！</h2>

    <?php if(session('success')): ?>
        <p style="color:green;"><?php echo e(session('success')); ?></p>
    <?php endif; ?>

    <div class="item-info">
        <p>商品名: <?php echo e($item->name); ?></p>
        <p>価格: ¥<?php echo e(number_format($item->price)); ?></p>
    </div>

    <a href="<?php echo e(route('items.index')); ?>" class="btn">商品一覧に戻る</a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/purchase/complete.blade.php ENDPATH**/ ?>