<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // ログイン成功後、商品一覧ページのマイリストタブを開く
        return redirect()->route('items.index', ['tab' => 'mylist']);
    }
}