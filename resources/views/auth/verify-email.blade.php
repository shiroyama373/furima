@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="verify-email-container">

@if (session('resent'))
    <div class="alert alert-success">
        認証メールを再送信しました
    </div>
@endif

    <h2>登録していただいたメールアドレスに認証メールを送付しました</h2>
    <p>メール認証を完了してください</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="verify-button">
            認証はこちらから
        </button>
    </form>

    <form method="POST" action="{{ route('verification.send') }}" class="resend-form">
        @csrf
        <button type="submit" class="resend-button">
            認証メールを再送する
        </button>
    </form>

</div>
@endsection