<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 商品名：入力必須
            'name' => 'required|string',

            // 商品説明：入力必須、最大255文字
            'description' => 'required|string|max:255',

            // 商品画像：必須、jpeg/png
            'image' => 'required|file|mimes:jpeg,png',

            // カテゴリー：選択必須
            'category_ids' => 'required',

            // 商品の状態：選択必須
            'condition' => 'required',

            // 価格：必須、数値、0以上
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名は必須です。',
            'description.required' => '商品説明は必須です。',
            'description.max' => '商品説明は255文字以内で入力してください。',
            'image.required' => '商品画像は必須です。',
            'image.mimes' => '商品画像はjpegまたはpng形式でアップロードしてください。',
            'category_ids.required' => 'カテゴリーを選択してください。',
            'condition.required' => '商品の状態を選択してください。',
            'price.required' => '価格は必須です。',
            'price.numeric' => '価格は数値で入力してください。',
            'price.min' => '価格は0円以上で入力してください。',
        ];
    }
}