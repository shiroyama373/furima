<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        // 各アイテムにコメントを1〜3件追加
        $items = Item::all();
        $users = User::all();

        foreach ($items as $item) {
            $users->random(rand(1,3))->each(function($user) use ($item) {
                Comment::create([
                    'item_id' => $item->id,
                    'user_id' => $user->id,
                    'comment' => 'これはダミーコメントです',
                ]);
            });
        }
    }
}