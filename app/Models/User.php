<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Item;
use App\Models\Purchase;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_first_login',
        'profile_completed',
        'postal_code',
        'address',
        'building',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // User → Item (1対多)
    public function items()
    {
        return $this->hasMany(\App\Models\Item::class);
    }

    // User → Purchase (1対多)
    public function purchases()
    {
        return $this->hasMany(\App\Models\Purchase::class);
    }

    // User → Comment (1対多)
    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    // User → Like (1対多)
    public function likes()
    {
        return $this->hasMany(\App\Models\Like::class);
    }

    // 出品した商品を取得
    public function sellItems()
    {
        return $this->hasMany(\App\Models\Item::class, 'user_id');
    }

    // 購入した商品を取得
    public function purchaseItems()
    {
        return $this->hasManyThrough(
            \App\Models\Item::class,      // 最終的に欲しいモデル
            \App\Models\Purchase::class,  // 中間モデル
            'user_id',                     // Purchaseテーブルの user_id
            'id',                          // Itemテーブルの id
            'id',                          // Userテーブルの id
            'item_id'                      // Purchaseテーブルの item_id
        );
    }

    // プロフィール画像のURLアクセサ
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            // storage/app/public に保存されている画像
            return asset('storage/' . $this->profile_image);
        }

        // デフォルト画像
        return asset('images/no_image.png');
    }
}