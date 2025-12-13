@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items-create.css') }}">
@endsection

@section('content')
<div class="container">
    <h1 class="page-title">商品の出品</h1>

    @if ($errors->any())
        <div style="color:red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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
            @error('image')
                <div class="image-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 商品詳細 -->
        <div class="form-section">
            <h2>商品詳細</h2>
            <hr>

            <!-- カテゴリー -->
            <h3>カテゴリー</h3>
            <div class="category-list">
                @php
                    $rows = [
                        ['ファッション','家電','インテリア','レディース','メンズ','コスメ'],
                        ['本','ゲーム','スポーツ','キッチン','ハンドメイド','アクセサリー'],
                        ['おもちゃ','ベビー・キッズ']
                    ];
                @endphp

                @foreach($rows as $row)
                    <div class="category-row">
                        @foreach($row as $name)
                            @php $category = $categories->firstWhere('name', $name); @endphp
                            @if($category)
                                <div class="category-item" data-id="{{ $category->id }}">
                                    {{ $category->name }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
            <input type="hidden" name="category_ids" id="category_ids" value="{{ old('category_ids') }}">
            @error('category_ids') <div class="error">{{ $message }}</div> @enderror

            <!-- 商品の状態 -->
  <h3>商品の状態</h3>
<select name="condition" class="condition-select">
     <option value="">選択してください</option>
    <option value="良好" {{ old('condition')=='良好' ? 'selected' : '' }}>良好</option>
    <option value="傷や汚れなし" {{ old('condition')=='傷や汚れなし' ? 'selected' : '' }}>傷や汚れなし</option>
    <option value="やや汚れあり" {{ old('condition')=='やや汚れあり' ? 'selected' : '' }}>やや汚れあり</option>
    <option value="状態が悪い" {{ old('condition')=='状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
</select>
@error('condition') <div class="error">{{ $message }}</div> @enderror


            <!-- 商品名 -->
            <h3>商品名</h3>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name') <div class="error">{{ $message }}</div> @enderror

            <!-- ブランド名 -->
            <h3>ブランド名</h3>
            <input type="text" name="brand" value="{{ old('brand') }}">
            @error('brand') <div class="error">{{ $message }}</div> @enderror

            <!-- 商品説明 -->
            <h3>商品の説明</h3>
            <textarea name="description" rows="5">{{ old('description') }}</textarea>
            @error('description') <div class="error">{{ $message }}</div> @enderror

            <!-- 販売価格 -->
            <h3>販売価格</h3>
            <div class="price-box">
                <span class="yen">￥</span>
                <input type="number" name="price" value="{{ old('price') }}" min="0">
            </div>
            @error('price') <div class="error">{{ $message }}</div> @enderror
        </div>

        <!-- 出品ボタン -->
        <button type="submit" class="btn-submit">出品する</button>
    </form>
</div>
@endsection

@section('scripts')
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
@endsection