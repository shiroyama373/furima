<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\FailedLoginResponse;
use App\Actions\Fortify\RegisterResponse;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\VerifyEmailViewResponse;
use Laravel\Fortify\Contracts\FailedLoginResponse as FailedLoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse as VerifyEmailViewResponseContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * サービス登録
     */
    public function register()
    {
        // ログイン失敗レスポンスを上書き
        $this->app->singleton(
            FailedLoginResponseContract::class,
            FailedLoginResponse::class
        );

        // 登録後レスポンスを上書き
        $this->app->singleton(
            RegisterResponseContract::class,
            RegisterResponse::class
        );

        // メール認証ビューを上書き
        $this->app->singleton(
            VerifyEmailViewResponseContract::class,
            VerifyEmailViewResponse::class
        );
    }

    /**
     * ブート
     */
    public function boot()
    {
        // 会員登録画面
        Fortify::registerView(fn() => view('auth.register'));

        // ログイン画面
        Fortify::loginView(fn() => view('auth.login'));

        // ユーザー作成処理
        Fortify::createUsersUsing(CreateNewUser::class);

        // 認証処理（ログイン時）
        Fortify::authenticateUsing(function ($request) {
            Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:8'],
            ], [
                'email.required' => 'メールアドレスを入力してください。',
                'email.email' => 'メールアドレスはメール形式で入力してください。',
                'password.required' => 'パスワードを入力してください。',
                'password.min' => 'パスワードは8文字以上で入力してください。',
            ])->validate();

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return null;
            }

            return $user;
        });

        // ログイン後のリダイレクト制御
        Fortify::redirects('login', function () {
            $user = auth()->user();

            // メール未認証の場合は認証通知画面へ
            if ($user && ! $user->hasVerifiedEmail()) {
                return route('verification.notice');
            }

            // 初回ログインならプロフィール編集へ
            if ($user && $user->is_first_login) {
                return route('profile.edit');
            }

            // 通常ログイン
            return route('items.index');
        });
    }
}