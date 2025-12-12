<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // テーブル名（省略するとモデル名の複数形が自動で使われます）
    protected $table = 'categories';

    // 書き込み可能なカラム
    protected $fillable = [
        'name',
    ];

    // リレーションの例（Itemとの多対多）
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_category', 'category_id', 'item_id');
    }
}