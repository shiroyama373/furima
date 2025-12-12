<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Item;

class PurchasesTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $items = Item::all();

        foreach ($items as $item) {
            // ランダムなユーザーが購入
            $user = $users->random();
            Purchase::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment_method' => 'クレジットカード',
            ]);
        }
    }
}