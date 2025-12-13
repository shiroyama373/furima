<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">

<div class="register-container">
    <div class="register-box">
        <h1 class="register-title">会員登録</h1>

        <form method="POST" action="{{ route('register.store') }}" novalidate>
            @csrf

            <!-- ユーザー名 -->
            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" 
                       class="@error('name') input-error @enderror" autofocus>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- メールアドレス -->
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" 
                       class="@error('email') input-error @enderror">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- パスワード -->
            <div class="form-group">
                <label for="password">パスワード</label>
                <input id="password" name="password" type="password" 
                       class="@error('password') input-error @enderror">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- パスワード確認 -->
            <div class="form-group">
                <label for="password_confirmation">パスワード確認</label>
                <input id="password_confirmation" name="password_confirmation" type="password" 
                       class="@error('password_confirmation') input-error @enderror">
                @error('password_confirmation')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="register-btn">登録する</button>

            <div class="login-link">
                <a href="{{ route('login') }}">ログインはこちら</a>
            </div>
        </form>
    </div>
</div>
@endsection