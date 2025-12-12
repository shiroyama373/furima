@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage_edit.css') }}">
@endsection

@section('content')
<div class="profile-edit-container">

    <!-- タイトル -->
    <h1 class="page-title" style="text-align:center;">プロフィール設定</h1>


    <hr class="tab-divider">

    <!-- フォーム -->
    <form method="POST" action="{{ route('mypage.update') }}" enctype="multipart/form-data">
        @csrf

        <!-- プロフィール画像 -->
        <div class="photo-section">
            <div class="profile-photo">
                <img id="profileImagePreview" 
     src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) . '?' . time() : asset('images/no_image.png') }}"
     alt="">
            </div>
            <div class="photo-button">
                <label class="file-label" style="border-color:red; color:red;">
                    画像を選択する
                    <input type="file" name="profile_image" accept="image/*" onchange="previewImage(event)">
                </label>
            </div>
        </div>

        <!-- ユーザー名 -->
        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 郵便番号 -->
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
            @error('postal_code')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 住所 -->
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
            @error('address')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 建物名 -->
        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}">
            @error('building')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- 更新ボタン -->
        <button type="submit" class="update-button">更新する</button>
    </form>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('profileImagePreview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection