<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::first(); // 固定ユーザーに紐付け

        $items = [
            ['腕時計', 15000, 'Rolax', 'スタイリッシュなデザインのメンズ腕時計', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg', '良好'],
            ['HDD', 5000, '西芝', '高速で信頼性の高いハードディスク', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg', '目立った傷や汚れなし'],
            ['玉ねぎ3束', 300, 'なし', '新鮮な玉ねぎ3束のセット', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg', 'やや傷や汚れあり'],
            ['革靴', 4000, 'なし', 'クラシックなデザインの革靴', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg', '状態が悪い'],
            ['ノートPC', 45000, 'なし', '高性能なノートパソコン', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg', '良好'],
            ['マイク', 8000, 'なし', '高音質のレコーディング用マイク', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg', '目立った傷や汚れなし'],
            ['ショルダーバッグ', 3500, 'なし', 'おしゃれなショルダーバッグ', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg', 'やや傷や汚れあり'],
            ['タンブラー', 500, 'なし', '使いやすいタンブラー', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg', '状態が悪い'],
            ['コーヒーミル', 4000, 'Starbacks', '手動のコーヒーミル', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg', '良好'],
            ['メイクセット', 2500, 'なし', '便利なメイクアップセット', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg', '目立った傷や汚れなし'],
        ];

        foreach ($items as $item) {
            Item::create([
                'user_id' => $user->id,
                'name' => $item[0],
                'price' => $item[1],
                'brand' => $item[2],
                'description' => $item[3],
                'image_path' => $item[4],
                'condition' => $item[5],
            ]);
        }
    }
}