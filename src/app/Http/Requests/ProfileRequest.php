<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // プロフィール画像：jpeg または png
            'profile_image' => 'nullable|file|mimes:jpeg,png',

            // ユーザー名：必須、20文字以内
            'name' => 'required|string|max:20',

            // 郵便番号：必須、ハイフンありの8文字（例：123-4567）
            'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],

            // 住所：必須
            'address' => 'required|string',
            'building' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'profile_image.mimes' => 'プロフィール画像はjpegまたはpng形式でアップロードしてください。',
            'name.required' => 'ユーザー名は必須です。',
            'name.max' => 'ユーザー名は20文字以内で入力してください。',
            'postal_code.required' => '郵便番号は必須です。',
            'postal_code.regex' => '郵便番号は「123-4567」のようにハイフンを入れて入力してください。',
            'address.required' => '住所は必須です。',
        ];
    }
}