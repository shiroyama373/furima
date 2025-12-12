<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    // ログインユーザーのみ許可
    public function authorize()
    {
        return auth()->check();
    }

    // バリデーションルール
    public function rules()
    {
        return [
            'comment' => 'required|string|max:255',
        ];
    }

    // エラーメッセージ
    public function messages()
    {
        return [
            'comment.required' => 'コメントを入力してください。',
            'comment.max'      => 'コメントは255文字以内で入力してください。',
        ];
    }
}