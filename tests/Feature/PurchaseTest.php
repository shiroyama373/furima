<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_purchase_page_is_displayed(): void
    {
        $user = User::factory()->create(['is_first_login' => false]);
        $this->actingAs($user);

        $item = Item::factory()->create(['price' => 10000]);

        $response = $this->get("/purchase/{$item->id}");

        $response->assertStatus(200);
    }

    public function test_purchased_item_is_added_to_profile_purchase_list(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'is_first_login' => false,
        ]);
        
        $this->actingAs($user);

        $item = Item::factory()->create(['name' => '購入テスト商品']);

        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee($item->name);
    }
}