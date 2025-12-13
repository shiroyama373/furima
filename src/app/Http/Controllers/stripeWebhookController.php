<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\Exception $e) {
            Log::error('Stripe Webhook Error', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Webhook Error'], 400);
        }

        if ($event->type === 'checkout.session.completed') {

            $session = $event->data->object;

            $itemId = $session->metadata->item_id ?? null;
            $userId = $session->metadata->user_id ?? null;

            if (!$itemId || !$userId) {
                Log::error('Metadata missing', ['session' => $session]);
                return response()->json(['error' => 'metadata missing'], 400);
            }

            // ✅ 重複防止
            if (!Purchase::where('item_id', $itemId)->where('user_id', $userId)->exists()) {
                Purchase::create([
                    'item_id' => $itemId,
                    'user_id' => $userId,
                    'payment_method' => $session->metadata->payment_method ?? 'card',
                    'postal_code' => null,
                    'prefecture'  => null,
                    'city'        => null,
                    'street'      => null,
                    'building'    => null,
                    'phone_number'=> null,
                ]);
            }

            // ✅ 売却済みに更新
            if ($item = Item::find($itemId)) {
                $item->update(['sold' => true]);
            }

            Log::info("Stripe payment completed: item={$itemId}, user={$userId}");
        }

        return response()->json(['status' => 'success']);
    }
}