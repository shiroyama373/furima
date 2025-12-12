<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = [
        'user_id',
        'item_id',
    ];

    // LikeはUserに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // LikeはItemに属する
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}