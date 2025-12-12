@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase_complete.css') }}">
@endsection

@section('content')
<div class="purchase-complete-container">
    <h2>購入が完了しました！</h2>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <div class="item-info">
        <p>商品名: {{ $item->name }}</p>
        <p>価格: ¥{{ number_format($item->price) }}</p>
    </div>

    <a href="{{ route('items.index') }}" class="btn">商品一覧に戻る</a>
</div>
@endsection