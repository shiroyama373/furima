<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = auth()->user()->fresh();
        if ($user->is_first_login) {
            return redirect()->route('mypage.edit');
        }
        $tab = $request->query('page', 'sell');
        $user->load(['sellItems', 'purchaseItems']);
        return view('mypage.show', compact('user', 'tab'));
    }

    public function edit()
    {
        $user = auth()->user()->fresh();
        return view('mypage.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
                \Storage::disk('public')->delete($user->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        } else {
            unset($data['profile_image']);
        }

        $data['is_first_login'] = false;
        $data['profile_completed'] = true;

        $user->update($data);

        return redirect()->route('items.index')
            ->with('success', 'プロフィールを保存しました。');
    }
}