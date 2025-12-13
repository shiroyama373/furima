<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/verify-email.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="verify-email-container">

<?php if(session('resent')): ?>
    <div class="alert alert-success">
        認証メールを再送信しました
    </div>
<?php endif; ?>

    <h2>登録していただいたメールアドレスに認証メールを送付しました</h2>
    <p>メール認証を完了してください</p>

    <form method="POST" action="<?php echo e(route('verification.send')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="verify-button">
            認証はこちらから
        </button>
    </form>

    <form method="POST" action="<?php echo e(route('verification.send')); ?>" class="resend-form">
        <?php echo csrf_field(); ?>
        <button type="submit" class="resend-button">
            認証メールを再送する
        </button>
    </form>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/auth/verify-email.blade.php ENDPATH**/ ?>