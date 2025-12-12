<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $table = 'item_category';

    protected $fillable = [
        'item_id',
        'category_id',
    ];

    // Itemとのリレーション
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Categoryとのリレーション
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}