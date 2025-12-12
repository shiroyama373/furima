<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    // 誰でもリクエスト可能にする
    public function authorize()
    {
        return true;
    }

    // バリデーションルール
    public function rules()
    {
        return [
            'payment_method' => 'required',
            'postal_code'    => 'required',
            'address'        => 'required',
        ];
    }

    // エラーメッセージ
    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください。',
            'postal_code.required'    => '郵便番号は必須です。',
            'address.required'        => '住所は必須です。',
        ];
    }
}