<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\FailedLoginResponse as FailedLoginResponseContract;
use Illuminate\Validation\ValidationException;

class FailedLoginResponse implements FailedLoginResponseContract
{
    public function toResponse($request)
    {
        throw ValidationException::withMessages([
            'password' => ['ログイン情報が登録されていません。']
        ]);
    }
}