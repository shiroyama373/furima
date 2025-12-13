<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\Purchase;

class AddressesTableSeeder extends Seeder
{
    public function run()
    {
        Purchase::all()->each(function ($purchase) {
            Address::create([
                'purchase_id' => $purchase->id,
                'postal_code' => '123-4567',
                'address' => '東京都新宿区西新宿1-1-1',
            ]);
        });
    }
}