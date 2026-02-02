<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    /**
     * 商品へのコメント保存（通常フォーム送信用）
     */
    public function store(CommentRequest $request, Item $item)
    {
        $validated = $request->validated();

        $item->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $validated['comment'],
        ]);

        return redirect()->back();
    }
}