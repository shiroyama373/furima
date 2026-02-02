<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_displays_user_information(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'is_first_login' => false,
        ]);

        $this->actingAs($user);

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品',
        ]);

        $purchasedItem = Item::factory()->create(['name' => '購入商品']);
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $purchasedItem->id,
        ]);

        $response = $this->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
    }

    public function test_listed_items_are_displayed_correctly(): void
    {
        $user = User::factory()->create([
            'is_first_login' => false,
        ]);
        
        $this->actingAs($user);

        $item1 = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品1',
        ]);

        $item2 = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品2',
        ]);

        $otherItem = Item::factory()->create(['name' => '他人の商品']);

        $response = $this->get('/mypage?page=sell');

        $response->assertStatus(200);
        $response->assertSee('出品商品1');
        $response->assertSee('出品商品2');
        $response->assertDontSee('他人の商品');
    }

    public function test_purchased_items_are_displayed_correctly(): void
    {
        $user = User::factory()->create([
            'is_first_login' => false,
        ]);
        
        $this->actingAs($user);

        $item1 = Item::factory()->create(['name' => '購入商品1']);
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item1->id,
        ]);

        $item2 = Item::factory()->create(['name' => '購入商品2']);
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item2->id,
        ]);

        $response = $this->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('購入商品1');
        $response->assertSee('購入商品2');
    }

    public function test_profile_edit_page_is_displayed(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'is_first_login' => false,
        ]);
        
        $this->actingAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);
    }
}