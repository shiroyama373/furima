<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\VerifyEmailViewResponse as VerifyEmailViewResponseContract;

class VerifyEmailViewResponse implements VerifyEmailViewResponseContract
{
    public function toResponse($request)
    {
        return view('auth.verify-email'); // あなたのメール認証Bladeファイル
    }
}