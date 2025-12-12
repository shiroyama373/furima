<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * 商品一覧
     */
public function index(Request $request)
{
    /**
     * 初期タブ設定
     * 未ログイン → recommend
     * ログイン後 → mylist
     */
    $defaultTab = Auth::check() ? 'mylist' : 'recommend';
    $tab = $request->query('tab', $defaultTab);

    // 🔍 検索ワード
    $keyword = $request->input('keyword');


    /**
     * 🔥 マイリストタブ
     */
    if ($tab === 'mylist') {

        // 未ログインならログインへ
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 🔥 検索があるなら「全商品から検索」
        if (!empty($keyword)) {
            $items = Item::where('name', 'like', "%{$keyword}%")
                ->latest()
                ->get();
        } else {
            // 🔥 検索がないなら「マイリストのみ」
            $items = Item::whereHas('likes', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->get();
        }

    } else {

        /**
         * 🔥 おすすめ（全商品）
         */
        $items = Item::when($keyword, function ($query) use ($keyword) {
                return $query->where('name', 'like', "%{$keyword}%");
            })
            ->latest()
            ->get();

        $tab = 'recommend';
    }

    return view('items.index', compact('items', 'tab', 'keyword'));
}
    /**
     * 商品詳細
     */
    public function show(Item $item)
    {
        // 関連データをまとめてロード
        $item->load(['categories', 'likes', 'comments.user', 'user']);

        return view('items.show', compact('item'));
    }

    /**
     * コメント投稿
     */
    public function postComment(CommentRequest $request, Item $item)
    {
        // CommentRequest がバリデーションとログインチェックを自動で行う
        $comment = $item->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => $comment->comment,
            'user_name' => $comment->user->name,
            'user_profile_image' => $comment->user->profile_image_url,
            'comments_count' => $item->comments()->count(),
        ]);
    }

    /**
     * いいねの切り替え
     */
    public function toggleLike(Item $item)
    {
        $user = auth()->user();
        $liked = $item->isLikedBy($user);

        if ($liked) {
            $item->likes()->detach($user->id);
        } else {
            $item->likes()->attach($user->id);
        }

        return response()->json([
            'liked' => !$liked,
            'likes_count' => $item->likes()->count(),
        ]);
    }
}