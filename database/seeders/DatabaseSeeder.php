<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            ItemsTableSeeder::class,
            ItemCategorySeeder::class,
            PurchasesTableSeeder::class,
            AddressesTableSeeder::class,
            CommentsTableSeeder::class,
            LikesTableSeeder::class,
            ItemSeeder::class,

        ]);
    }
}