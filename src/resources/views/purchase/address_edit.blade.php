@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase_address.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    <h2 class="edit-title">住所の変更</h2>

    <form action="{{ route('purchase.updateAddress', ['item' => $item->id]) }}" method="POST" class="edit-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $address['postal_code'] ?? '') }}">
            @error('postal_code')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
    <label for="address">住所</label>
    <input type="text" name="address" id="address" 
           value="{{ old('address', $address['address'] ?? '') }}">
    @error('address')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $address['building'] ?? '') }}">
            @error('building')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="update-btn">更新する</button>
    </form>
</div>
@endsection