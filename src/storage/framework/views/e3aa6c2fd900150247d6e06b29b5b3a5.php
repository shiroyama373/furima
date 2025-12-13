<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-container">
    <div class="login-box">
        <h1 class="login-title">ログイン</h1>

        <form method="POST" action="<?php echo e(route('login')); ?>" novalidate>
            <?php echo csrf_field(); ?>

  <!-- メールアドレス -->
<div class="form-group">
    <label for="email">メールアドレス</label>
    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required>
    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<!-- パスワード -->
<div class="form-group">
    <label for="password">パスワード</label>
    <input id="password" type="password" name="password" required>
    <?php if($errors->has('password')): ?>
        <div class="error"><?php echo e($errors->first('password')); ?></div>
    <?php endif; ?>
</div>

            <button type="submit" class="login-btn">ログイン</button>
        </form>

        <div class="register-link">
            <a href="<?php echo e(route('register')); ?>">会員登録はこちら</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/auth/login.blade.php ENDPATH**/ ?>