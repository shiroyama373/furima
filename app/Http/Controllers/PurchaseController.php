<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    // 購入画面表示
    public function create(Item $item)
    {
        $user = auth()->user()->fresh();

        if (request()->has('cancel')) {
            session()->flash('error', '決済をキャンセルしました');
        }

        $purchase = Purchase::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->latest()
            ->first();

        $address = [
            'postal_code' => $user->postal_code,
            'address'     => $user->address,
            'building'    => $user->building,
        ];

        return view('purchase.create', compact('item', 'user', 'purchase', 'address'));
    }

    // 購入処理
    public function store(PurchaseRequest $request, Item $item)
    {
        $data = $request->validated();

        if ($item->sold) {
            return back()->with('error', 'この商品はすでに購入されています。');
        }

        if (empty($data['payment_method'])) {
            return back()->with('error', '支払い方法を選択してください');
        }

        // ★ 支払い方法をsessionに保存
        session(['payment_method' => $data['payment_method']]);

        /**
         * 🔥 コンビニ払い
         */
        if ($data['payment_method'] === 'convenience_store') {
            return $this->konbiniCheckout($item);
        }

        /**
         * 🔥 カード払い
         */
        if ($data['payment_method'] === 'card') {
            return redirect()->route('stripe.checkout', ['item' => $item->id]);
        }

        return back()->with('error', '支払い方法を選択してください');
    }

    // ★ コンビニ専用 Stripe セッション作成
    public function konbiniCheckout(Item $item)
    {
        if ($item->sold) {
            return back()->with('error', 'この商品はすでに購入されています。');
        }

        // ★★★ Stripeセッション作成前に購入データを保存 ★★★
        Purchase::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'payment_method' => 'convenience_store',
        ]);

        // ★★★ 商品をsoldに更新 ★★★
        $item->update(['sold' => 1]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $imageUrl = filter_var($item->image_path, FILTER_VALIDATE_URL)
            ? $item->image_path
            : asset('storage/' . $item->image_path);

        try {
            $session = Session::create([
                'payment_method_types' => ['konbini'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'jpy',
                            'unit_amount' => $item->price,
                            'product_data' => [
                                'name' => $item->name,
                                'images' => [$imageUrl],
                            ],
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('purchase.complete', $item->id),
                'cancel_url'  => route('purchase.create', $item->id) . '?cancel=1',
                'metadata'    => [
                    'item_id'        => $item->id,
                    'user_id'        => auth()->id(),
                    'payment_method' => 'konbini',
                ],
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with(
                'error',
                'コンビニ決済の作成に失敗しました:' . $e->getMessage()
            );
        }
    }

    // 住所編集画面
    public function editAddress(Item $item)
    {
        $user = auth()->user();

        $address = [
            'postal_code' => $user->postal_code,
            'address'     => $user->address,
            'building'    => $user->building,
        ];

        return view('purchase.address_edit', compact('item', 'address'));
    }

    // 住所更新
    public function updateAddress(AddressRequest $request, Item $item)
    {
        $user = auth()->user();
        $data = $request->validated();

        $user->update([
            'postal_code' => $data['postal_code'],
            'address'     => $data['address'],
            'building'    => $data['building'] ?? null,
        ]);

        return redirect()
            ->route('purchase.create', $item->id)
            ->with('success', '住所を更新しました。');
    }

    // Stripe カード決済
    public function checkout(Item $item)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        if ($item->sold) {
            return redirect()->back()->with('error', 'この商品はすでに購入されています。');
        }

        $imageUrl = filter_var($item->image_path, FILTER_VALIDATE_URL)
            ? $item->image_path
            : asset('storage/' . $item->image_path);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'jpy',
                        'unit_amount' => $item->price,
                        'product_data' => [
                            'name' => $item->name,
                            'images' => [$imageUrl],
                        ],
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('purchase.complete', $item->id),
            'cancel_url'  => route('purchase.create', $item->id) . '?cancel=1',
            'metadata'    => [
                'item_id'        => $item->id,
                'user_id'        => auth()->id(),
                'payment_method' => 'card',
            ],
        ]);

        return redirect($session->url);
    }

    // 完了画面
    public function complete(Item $item)
    {
        // すでに購入済みかチェック
        $existingPurchase = Purchase::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->first();

        // まだ購入データがない場合のみ保存（カード払い用）
        if (!$existingPurchase && !$item->sold) {
            // ★ sessionから支払い方法を取得
            $paymentMethod = session('payment_method', 'card');

            // 購入データを保存
            Purchase::create([
                'user_id'        => auth()->id(),
                'item_id'        => $item->id,
                'payment_method' => $paymentMethod,
            ]);

            // 商品をsoldに更新
            $item->update(['sold' => 1]);
        }

        // sessionをクリア
        session()->forget('payment_method');

        return view('purchase.complete', compact('item'));
    }
}