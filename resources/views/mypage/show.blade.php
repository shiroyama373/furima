@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage_show.css') }}">
@endsection

@section('content')
<div class="profile-container">

    <!-- 上段：写真 + 名前 + 編集ボタン -->
    <div class="profile-header">
        <div class="profile-photo">
            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default_profile.png') }}">
        </div>
        <div class="profile-info">
            <div class="profile-name">{{ $user->name }}</div>
            <a href="{{ route('mypage.edit') }}" class="profile-edit">プロフィールを編集</a>
        </div>
    </div>

    <!-- 中段：タブ -->
    <ul class="profile-tabs">
        <li class="{{ $tab === 'sell' ? 'active' : '' }}">
            <a href="{{ route('mypage.show', ['page' => 'sell']) }}">出品した商品</a>
        </li>
        <li class="{{ $tab === 'buy' ? 'active' : '' }}">
            <a href="{{ route('mypage.show', ['page' => 'buy']) }}">購入した商品</a>
        </li>
    </ul>

    <!-- タブ下の太い線 -->
    <hr class="tab-divider">

    <!-- 商品一覧 -->
    <div class="product-list">
        @php
            $items = $tab === 'sell' ? $user->sellItems ?? [] : $user->purchaseItems ?? [];
        @endphp

        @forelse($items as $item)
            @php
                $imageUrl = filter_var($item->image_path, FILTER_VALIDATE_URL)
                    ? $item->image_path
                    : Storage::url($item->image_path);
            @endphp
            <div class="product-card">
                <img src="{{ $imageUrl }}" alt="{{ $item->name }}">
                <p class="product-name">{{ $item->name }}</p>

                @if($item->sold)
                    <span class="sold-badge">SOLD</span>
                @endif
            </div>
        @empty
            <p class="no-items">表示する商品はありません</p>
        @endforelse
    </div>

</div>
@endsection