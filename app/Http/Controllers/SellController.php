<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all(); // DBから全カテゴリ取得
        return view('items.create', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        // 画像保存
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('images', 'public');
        }

        // 商品を作成
        $item = Item::create($data);

        // カテゴリー紐付け（複数可）
        if ($request->filled('category_ids')) {
            $categoryIds = explode(',', $request->category_ids);
            $item->categories()->sync($categoryIds);
        }

        return redirect()->route('items.show', $item->id)
                         ->with('success', '商品を出品しました。');
    }
}