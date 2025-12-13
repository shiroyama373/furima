<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    // 書き込み可能なカラム
    protected $fillable = [
        'purchase_id',
        'postal_code',
        'address',
    ];

    // リレーション：AddressはPurchaseに属する（1対1の関係）
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}