@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase_create.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    <div class="purchase-main">

        <form action="{{ route('purchase.store', $item->id) }}" method="POST">
            @csrf

            {{-- 左側：商品情報と支払い方法 --}}
            <div class="purchase-left">

                @php
                    $imageUrl = filter_var($item->image_path, FILTER_VALIDATE_URL)
                        ? $item->image_path
                        : Storage::url($item->image_path);
                @endphp

                <div class="product-info-row">
                    <div class="product-image">
                        <img src="{{ $imageUrl }}" alt="商品画像">
                    </div>
                    <div class="product-text">
                        <div class="product-title">{{ $item->name }}</div>
                        <div class="product-price">¥{{ number_format($item->price) }}</div>
                    </div>
                </div>

                <hr class="gray-line">

                {{-- 支払い方法 --}}
                <div class="section">
                    <span class="section-title">支払い方法</span>
                </div>

                <select name="payment_method" class="payment-select">
                    <option value="">選択してください</option>
                    <option value="card" {{ old('payment_method')=='card' ? 'selected':'' }}>
                        カード払い
                    </option>
                    <option value="convenience_store" {{ old('payment_method')=='convenience_store' ? 'selected':'' }}>
                        コンビニ払い
                    </option>
                </select>

                @error('payment_method')
                    <p style="color:red;">{{ $message }}</p>
                @enderror

                @if(session('error'))
                    <p style="color:red;">{{ session('error') }}</p>
                @endif

                <hr class="gray-line">

                {{-- 配送先 --}}
                <div class="section">
                    <span class="section-title">配送先</span>
                    <a href="{{ route('purchase.address', ['item' => $item->id]) }}" class="change-link">
                        変更する
                    </a>
                </div>

                {{-- ここを $address に変更 --}}
                <div class="address-info">
                    <p>
                        〒{{ $address['postal_code'] }}<br>
                        {{ $address['address'] }}<br>
                        {{ $address['building'] }}
                    </p>
                </div>

            </div>

            {{-- 右側：購入サマリーとボタン --}}
            <div class="purchase-right">
                <div class="summary-box">
                    <div class="summary-item">
                        <span>商品代金</span>
                        <span class="summary-value">¥{{ number_format($item->price) }}</span>
                    </div>

                    <div class="summary-item">
                        <span>支払い方法</span>
                        <span class="summary-value">
                            @if(old('payment_method') == 'card')
                                カード払い
                            @elseif(old('payment_method') == 'convenience_store')
                                コンビニ払い
                            @else
                                未選択
                            @endif
                        </span>
                    </div>
                </div>

                {{-- hidden 配送先情報も $address に変更 --}}
                <input type="hidden" name="postal_code" value="{{ $address['postal_code'] }}">
                <input type="hidden" name="address" value="{{ $address['address'] }}">
                <input type="hidden" name="building" value="{{ $address['building'] }}">

                {{-- 購入ボタン --}}
                <button type="submit" class="purchase-btn">
                    購入する
                </button>
            </div>

        </form>

    </div>
</div>
@endsection