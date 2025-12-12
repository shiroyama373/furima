@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items_show.css') }}">
@endsection

@section('content')

<div class="item-detail-body">
    <div class="item-detail-card">
        <!-- 左：商品画像 -->
<div class="image-wrapper">
    @if ($item->sold)
        <span class="sold-label">Sold</span>
    @endif
    <img 
        src="{{ \Illuminate\Support\Str::startsWith($item->image_path, ['http://', 'https://']) ? $item->image_path : asset('storage/' . $item->image_path) }}" 
        alt="{{ $item->name }}" 
        class="item-image"
        >
</div>

        <!-- 右：商品情報 -->
        <div class="item-info">
            <h1 class="item-name">{{ $item->name }}</h1>
            <p class="item-brand">ブランド名:{{ $item->brand ?? '' }}</p>
            <p class="item-price">¥{{ number_format($item->price) }}（税込）</p>

            <!-- いいね & コメント数 -->
            @php
                $isLiked = auth()->check() ? $item->isLikedBy(auth()->user()) : false;
            @endphp

            <div class="item-stats">
                <!-- いいねボタン -->
                <button type="button" class="btn-like {{ $isLiked ? 'liked' : '' }}" @if(auth()->check()) data-item-id="{{ $item->id }}" @endif>
                    <i class="{{ $isLiked ? 'fas' : 'far' }} fa-heart"></i>
                    <span class="count">{{ $item->likes->count() }}</span>
                </button>

                <!-- コメントボタン（線アイコン） -->
                <div class="btn-comment">
                    <i class="far fa-comment"></i>
                    <span class="count">{{ $item->comments->count() }}</span>
                </div>
            </div>

            <!-- 購入ボタン -->
            @if(!$item->sold)
                @auth
                    <form action="{{ route('purchase.create', $item->id) }}" method="get">
                        <button type="submit" class="btn-purchase">購入手続きへ</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-purchase">購入手続きへ</a>
                @endauth
            @endif

            <!-- 商品説明ブロック -->
            <div class="item-block item-description-block">
                <h3>商品説明</h3>
                <p class="item-description">{{ $item->description }}</p>
            </div>

            <!-- 商品情報ブロック -->
          <!-- 商品情報ブロック -->
<div class="item-block item-info-block">
    <h3>商品の情報</h3>

  <div class="category-row">
    <h4 class="info-label">カテゴリー</h4>
    <div class="item-categories">
        @forelse($item->categories as $category)
            <span class="category-label">{{ $category->name }}</span>
        @empty
            <span class="category-label">未設定</span>
        @endforelse
    </div>
</div>
<div class="category-row">
    <h4 class="info-label">商品の状態</h4>
    <p class="item-condition">{{ $item->condition }}</p>
</div>

<!-- 商品の状態の下 -->
<div class="comments-section">

    <!-- コメント見出しとコメント数 -->
    <div class="comments-header">
        <span class="comments-label">コメント</span>
        <span class="comments-count">({{ $item->comments->count() }})</span>
    </div>

    <!-- コメント一覧 -->
 <div class="comments-list">
    @forelse($item->comments as $comment)
        <div class="comment-item">
            <div class="comment-header">
                <!-- 投稿者アイコン -->
                <div class="comment-icon">
                    @if($comment->user->profile_image_url)
                        <img src="{{ $comment->user->profile_image_url }}" alt="{{ $comment->user->name }}">
                    @else
                        <div class="dummy-icon"></div>
                    @endif
                </div>
                <!-- 投稿者名前 -->
                <span class="comment-username">{{ $comment->user->name }}</span>
            </div>
            <!-- コメント本文 -->
            <div class="comment-body">
                {{ $comment->comment }}
            </div>
        </div>
    @empty
        <p class="no-comments">コメントはまだありません</p>
    @endforelse
</div>
    <!-- コメント投稿フォーム -->
    <div class="comment-post-section">
        <h4>商品へのコメント</h4>
        <form action="{{ route('items.comment', $item->id) }}" method="POST" class="comment-post-form">
            @csrf
            <textarea name="comment" placeholder="コメントを入力">{{ old('comment') }}</textarea>
            @error('comment')
                <div class="error-comment-post">{{ $message }}</div>
            @enderror

            @auth
                <button type="submit" class="btn-comment-post">コメントを送信</button>
            @else
                <a href="{{ route('login') }}" class="btn-comment-post">コメントを送信</a>
            @endauth
        </form>
    </div>
</div>

</div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@auth
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
@endauth
@endsection