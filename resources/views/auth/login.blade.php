@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-container">
    <div class="login-box">
        <h1 class="login-title">ログイン</h1>

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

  <!-- メールアドレス -->
<div class="form-group">
    <label for="email">メールアドレス</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror
</div>

<!-- パスワード -->
<div class="form-group">
    <label for="password">パスワード</label>
    <input id="password" type="password" name="password" required>
    @if($errors->has('password'))
        <div class="error">{{ $errors->first('password') }}</div>
    @endif
</div>

            <button type="submit" class="login-btn">ログイン</button>
        </form>

        <div class="register-link">
            <a href="{{ route('register') }}">会員登録はこちら</a>
        </div>
    </div>
</div>
@endsection