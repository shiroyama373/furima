<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Stripe\Stripe;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $event = $request->all();
        
        if ($event['type'] === 'checkout.session.completed') {

            $session = $event['data']['object'];

            Purchase::create([
                'user_id' => $session['metadata']['user_id'],
                'item_id' => $session['metadata']['item_id'],
                'payment_method' => $session['metadata']['payment_method'] ?? 'card',
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}