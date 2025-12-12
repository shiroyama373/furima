<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;

class ItemCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        Item::all()->each(function ($item) use ($categories) {
            $item->categories()->attach(
                $categories->random(rand(1,2))->pluck('id')->toArray()
            );
        });
    }
}