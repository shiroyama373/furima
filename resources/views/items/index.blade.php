@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@php
    // 🔥 ログインしていればマイリスト、ゲストはおすすめを初期表示
    $defaultTab = auth()->check() ? 'mylist' : 'recommend';
    $currentTab = request('tab', $defaultTab);
@endphp

<div class="items-body">

    <!-- おすすめ / マイリストタブ -->
    <div class="tabs">
        <a href="{{ route('items.index', ['tab' => 'recommend']) }}"
           class="tab {{ $currentTab === 'recommend' ? 'active' : '' }}">
            おすすめ
        </a>

        <a href="{{ route('items.index', ['tab' => 'mylist']) }}"
           class="tab {{ $currentTab === 'mylist' ? 'active' : '' }}">
            マイリスト
        </a>
    </div>

    <!-- 下にグレーの線 -->
    <hr class="tab-underline">

    <!-- 商品一覧 -->
    <div class="items-list">
        @foreach ($items as $item)
            @php
                $imageUrl = \Illuminate\Support\Str::startsWith($item->image_path, ['http://','https://'])
                    ? $item->image_path
                    : asset('storage/' . $item->image_path);
            @endphp

            <div class="item-card">
                <div class="image-wrapper">
                    @if ($item->sold)
                        <span class="sold-label">Sold</span>
                    @endif

                    <a href="{{ route('items.show', $item->id) }}">
                        <img src="{{ $imageUrl }}" alt="{{ $item->name }}" class="item-image">
                    </a>
                </div>

                <h3 class="item-name">{{ $item->name }}</h3>
            </div>
        @endforeach
    </div>

</div>
@endsection