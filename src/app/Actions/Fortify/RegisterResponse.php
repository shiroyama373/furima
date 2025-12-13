<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        // メール未認証なら認証通知画面へ
        if ($user && ! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // 初回ログインならプロフィール編集へ
        if ($user && $user->is_first_login) {
            return redirect()->route('profile.edit');
        }

        // 通常ログイン
        return redirect()->route('items.index');
    }
}