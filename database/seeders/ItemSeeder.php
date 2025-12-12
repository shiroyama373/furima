<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    public function run()
    {
        // 外部キー制約を無効化
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 全削除
        Item::query()->delete();

        // 外部キー制約を有効化
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $items = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'sold' => false,
                'user_id' => 1,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'condition' => '良好'
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'sold' => false,
                'user_id' => 1,
                'description' => '高速で信頼性の高いハードディスク',
                'condition' => '目立った傷や汚れなし'
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'sold' => false,
                'user_id' => 1,
                'description' => '新鮮な玉ねぎ3束のセット',
                'condition' => 'やや傷や汚れあり'
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'sold' => false,
                'user_id' => 1,
                'description' => 'クラシックなデザインの革靴',
                'condition' => '状態が悪い'
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'sold' => false,
                'user_id' => 1,
                'description' => '高性能なノートパソコン',
                'condition' => '良好'
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'sold' => false,
                'user_id' => 1,
                'description' => '高音質のレコーディング用マイク',
                'condition' => '目立った傷や汚れなし'
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'sold' => false,
                'user_id' => 1,
                'description' => 'おしゃれなショルダーバッグ',
                'condition' => 'やや傷や汚れあり'
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'sold' => false,
                'user_id' => 1,
                'description' => '使いやすいタンブラー',
                'condition' => '状態が悪い'
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'sold' => false,
                'user_id' => 1,
                'description' => '手動のコーヒーミル',
                'condition' => '良好'
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'sold' => false,
                'user_id' => 1,
                'description' => '便利なメイクアップセット',
                'condition' => '目立った傷や汚れなし'
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}