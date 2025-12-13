<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/items-create.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="page-title">商品の出品</h1>

    <?php if($errors->any()): ?>
        <div style="color:red;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('sell.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <!-- 商品画像 -->
        <div class="form-section">
            <h3>商品画像</h3>
            <div class="image-box-outer">
                <div class="image-box-inner">
                    <label class="image-label">
                        画像を選択する
                        <input type="file" name="image" id="image" accept="image/*">
                    </label>
                    <img id="image-preview" class="image-preview" style="display:none;">
                </div>
            </div>
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="image-error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- 商品詳細 -->
        <div class="form-section">
            <h2>商品詳細</h2>
            <hr>

            <!-- カテゴリー -->
            <h3>カテゴリー</h3>
            <div class="category-list">
                <?php
                    $rows = [
                        ['ファッション','家電','インテリア','レディース','メンズ','コスメ'],
                        ['本','ゲーム','スポーツ','キッチン','ハンドメイド','アクセサリー'],
                        ['おもちゃ','ベビー・キッズ']
                    ];
                ?>

                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="category-row">
                        <?php $__currentLoopData = $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $category = $categories->firstWhere('name', $name); ?>
                            <?php if($category): ?>
                                <div class="category-item" data-id="<?php echo e($category->id); ?>">
                                    <?php echo e($category->name); ?>

                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <input type="hidden" name="category_ids" id="category_ids" value="<?php echo e(old('category_ids')); ?>">
            <?php $__errorArgs = ['category_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <!-- 商品の状態 -->
  <h3>商品の状態</h3>
<select name="condition" class="condition-select">
     <option value="">選択してください</option>
    <option value="良好" <?php echo e(old('condition')=='良好' ? 'selected' : ''); ?>>良好</option>
    <option value="傷や汚れなし" <?php echo e(old('condition')=='傷や汚れなし' ? 'selected' : ''); ?>>傷や汚れなし</option>
    <option value="やや汚れあり" <?php echo e(old('condition')=='やや汚れあり' ? 'selected' : ''); ?>>やや汚れあり</option>
    <option value="状態が悪い" <?php echo e(old('condition')=='状態が悪い' ? 'selected' : ''); ?>>状態が悪い</option>
</select>
<?php $__errorArgs = ['condition'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


            <!-- 商品名 -->
            <h3>商品名</h3>
            <input type="text" name="name" value="<?php echo e(old('name')); ?>">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <!-- ブランド名 -->
            <h3>ブランド名</h3>
            <input type="text" name="brand" value="<?php echo e(old('brand')); ?>">
            <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <!-- 商品説明 -->
            <h3>商品の説明</h3>
            <textarea name="description" rows="5"><?php echo e(old('description')); ?></textarea>
            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <!-- 販売価格 -->
            <h3>販売価格</h3>
            <div class="price-box">
                <span class="yen">￥</span>
                <input type="number" name="price" value="<?php echo e(old('price')); ?>" min="0">
            </div>
            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- 出品ボタン -->
        <button type="submit" class="btn-submit">出品する</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>

    const imageInput = document.getElementById('image');
const imagePreview = document.getElementById('image-preview');
const imageLabel = document.querySelector('.image-label');

imageInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
            imageLabel.style.display = 'none'; 
        }
        reader.readAsDataURL(file);
    }
});




    // カテゴリ選択
    const categoryItems = document.querySelectorAll('.category-item');
    const categoryIdsInput = document.getElementById('category_ids');
    categoryItems.forEach(item => {
        item.addEventListener('click', function(){
            item.classList.toggle('selected');
            const selectedIds = Array.from(document.querySelectorAll('.category-item.selected'))
                                     .map(el => el.dataset.id);
            categoryIdsInput.value = selectedIds.join(',');
        });
    });

    // 初期値復元
    const oldCategoryIds = categoryIdsInput.value.split(',');
    categoryItems.forEach(item => {
        if(oldCategoryIds.includes(item.dataset.id)){
            item.classList.add('selected');
        }
    });

    // 商品状態セレクトボックスの背景色切替
    const conditionSelect = document.querySelector('select[name="condition"]');
    conditionSelect.addEventListener('change', function() {
        if(this.value === "") {
            this.classList.remove('selected'); // 初期値なら白背景
        } else {
            this.classList.add('selected');    // 選択時は濃いグレー
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/items/create.blade.php ENDPATH**/ ?>