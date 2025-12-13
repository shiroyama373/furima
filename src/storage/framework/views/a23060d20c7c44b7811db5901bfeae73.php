<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/purchase_create.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="purchase-container">
    <div class="purchase-main">

        <form action="<?php echo e(route('purchase.store', $item->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>

            
            <div class="purchase-left">

                <?php
                    $imageUrl = filter_var($item->image_path, FILTER_VALIDATE_URL)
                        ? $item->image_path
                        : Storage::url($item->image_path);
                ?>

                <div class="product-info-row">
                    <div class="product-image">
                        <img src="<?php echo e($imageUrl); ?>" alt="商品画像">
                    </div>
                    <div class="product-text">
                        <div class="product-title"><?php echo e($item->name); ?></div>
                        <div class="product-price">¥<?php echo e(number_format($item->price)); ?></div>
                    </div>
                </div>

                <hr class="gray-line">

                
                <div class="section">
                    <span class="section-title">支払い方法</span>
                </div>

                <select name="payment_method" class="payment-select">
                    <option value="">選択してください</option>
                    <option value="card" <?php echo e(old('payment_method')=='card' ? 'selected':''); ?>>
                        カード払い
                    </option>
                    <option value="convenience_store" <?php echo e(old('payment_method')=='convenience_store' ? 'selected':''); ?>>
                        コンビニ払い
                    </option>
                </select>

                <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p style="color:red;"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <?php if(session('error')): ?>
                    <p style="color:red;"><?php echo e(session('error')); ?></p>
                <?php endif; ?>

                <hr class="gray-line">

                
                <div class="section">
                    <span class="section-title">配送先</span>
                    <a href="<?php echo e(route('purchase.address', ['item' => $item->id])); ?>" class="change-link">
                        変更する
                    </a>
                </div>

                
                <div class="address-info">
                    <p>
                        〒<?php echo e($address['postal_code']); ?><br>
                        <?php echo e($address['address']); ?><br>
                        <?php echo e($address['building']); ?>

                    </p>
                </div>

            </div>

            
            <div class="purchase-right">
                <div class="summary-box">
                    <div class="summary-item">
                        <span>商品代金</span>
                        <span class="summary-value">¥<?php echo e(number_format($item->price)); ?></span>
                    </div>

                    <div class="summary-item">
                        <span>支払い方法</span>
                        <span class="summary-value">
                            <?php if(old('payment_method') == 'card'): ?>
                                カード払い
                            <?php elseif(old('payment_method') == 'convenience_store'): ?>
                                コンビニ払い
                            <?php else: ?>
                                未選択
                            <?php endif; ?>
                        </span>
                    </div>
                </div>

                
                <input type="hidden" name="postal_code" value="<?php echo e($address['postal_code']); ?>">
                <input type="hidden" name="address" value="<?php echo e($address['address']); ?>">
                <input type="hidden" name="building" value="<?php echo e($address['building']); ?>">

                
                <button type="submit" class="purchase-btn">
                    購入する
                </button>
            </div>

        </form>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/purchase/create.blade.php ENDPATH**/ ?>