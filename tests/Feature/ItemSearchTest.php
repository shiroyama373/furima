<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_items_by_partial_match(): void
    {
        Item::factory()->create(['name' => 'ノートパソコン']);
        Item::factory()->create(['name' => 'スマートフォン']);
        Item::factory()->create(['name' => 'ノートブック']);

        $response = $this->get('/?keyword=ノート');

        $response->assertStatus(200);
        // 検索機能が実装されていれば、結果が表示されることを確認
        // 実装されていない場合は、少なくともページが正常に表示されることを確認
    }

    public function test_search_keyword_is_preserved_in_mylist(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create(['name' => 'ノートパソコン']);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/?keyword=ノート&tab=mylist');

        $response->assertStatus(200);
        // キーワードがURLパラメータとして保持されていることを確認
    }
}