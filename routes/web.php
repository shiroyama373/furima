<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\CommentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\StripeWebhookController;

/*
|--------------------------------------------------------------------------
| 商品一覧
|--------------------------------------------------------------------------
*/
Route::get('/', [ItemController::class, 'index'])
    ->name('items.index');

/*
|--------------------------------------------------------------------------
| 商品詳細
|--------------------------------------------------------------------------
*/
Route::get('/items/{item}', [ItemController::class, 'show'])
    ->name('items.show');

/*
|--------------------------------------------------------------------------
| コメント（ログイン必須）
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/items/{item}/comment', [CommentController::class, 'store'])
        ->name('items.comment');

    Route::post('/items/{item}/toggle-like', [ItemController::class, 'toggleLike'])
        ->name('items.toggle-like');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');
});

/*
|--------------------------------------------------------------------------
| 購入画面
|--------------------------------------------------------------------------
*/
Route::get('/purchase/complete/{item}', [PurchaseController::class, 'complete'])
    ->middleware('auth')
    ->name('purchase.complete');

Route::get('/purchase/{item}', [PurchaseController::class, 'create'])
    ->middleware('auth')
    ->name('purchase.create');

Route::post('/purchase/{item}', [PurchaseController::class, 'store'])
    ->middleware('auth')
    ->name('purchase.store');

/*
|--------------------------------------------------------------------------
| 住所変更（ユーザー情報ベース）
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])
        ->name('purchase.address');

    Route::put('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])
        ->name('purchase.updateAddress');
});

/*
|--------------------------------------------------------------------------
| 商品出品
|--------------------------------------------------------------------------
*/
Route::get('/sell', [SellController::class, 'create'])
    ->middleware('auth')
    ->name('sell.create');

Route::post('/sell', [SellController::class, 'store'])
    ->middleware('auth')
    ->name('sell.store');

/*
|--------------------------------------------------------------------------
| マイページ
|--------------------------------------------------------------------------
*/
Route::get('/mypage', [UserController::class, 'show'])
    ->middleware('auth')
    ->name('mypage.show');

Route::get('/mypage/profile', [UserController::class, 'edit'])
    ->middleware('auth')
    ->name('mypage.edit');

Route::post('/mypage/profile', [UserController::class, 'update'])
    ->middleware('auth')
    ->name('mypage.update');

/*
|--------------------------------------------------------------------------
| メール認証リンク
|--------------------------------------------------------------------------
*/
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // 認証完了

    if (! $request->user()->profile_completed) {
        return redirect()->route('mypage.edit');
    }

    return redirect('/items');
})->middleware(['auth', 'signed'])->name('verification.verify');

/*
|--------------------------------------------------------------------------
| Stripe
|--------------------------------------------------------------------------
*/
// カード決済
Route::get('/stripe/checkout/{item}', [PurchaseController::class, 'checkout'])
    ->middleware('auth')
    ->name('stripe.checkout');

// コンビニ決済
Route::post('/stripe/konbini/{item}', [PurchaseController::class, 'konbiniCheckout'])
    ->middleware('auth')
    ->name('stripe.konbini');

// Webhook（カード・コンビニ共通）
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);