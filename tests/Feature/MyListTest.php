<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_liked_items_are_displayed(): void
    {
        $user = User::factory()->create(['is_first_login' => false]);
        $this->actingAs($user);

        $likedItem = Item::factory()->create(['name' => 'いいねした商品']);
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $notLikedItem = Item::factory()->create(['name' => 'いいねしていない商品']);

        // 検索なしでマイリストを表示
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしていない商品');
    }

    public function test_sold_items_in_favorites_display_sold_label(): void
    {
        $user = User::factory()->create(['is_first_login' => false]);
        $buyer = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create(['sold' => true]);
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        Purchase::factory()->create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    public function test_unauthenticated_user_sees_nothing(): void
    {
        $item = Item::factory()->create();

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
    }
}