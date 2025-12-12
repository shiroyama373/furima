<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Like;
use App\Models\User;
use App\Models\Item;

class LikesTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        Item::all()->each(function ($item) use ($user) {
            Like::create([
                'item_id' => $item->id,
                'user_id' => $user->id,
            ]);
        });
    }
}