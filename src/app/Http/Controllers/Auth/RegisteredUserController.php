<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    // 登録フォーム表示
    public function create()
    {
        return view('auth.register'); // Bladeを返す
    }

    // ユーザー登録処理
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        auth()->login($user);

        return redirect()
            ->route('mypage.edit')
            ->with('success', '登録が完了しました。プロフィールを設定してください。');
    }
}