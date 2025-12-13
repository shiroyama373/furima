<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchases';

    protected $fillable = [
    'user_id',
    'item_id',
    'payment_method',
    'postal_code',
    'address',
    'building',
];

    // Userとのリレーション（PurchaseはUserに属する）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Itemとのリレーション（PurchaseはItemに属する）
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}