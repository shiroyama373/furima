<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellTest extends TestCase
{
    use RefreshDatabase;

    public function test_sell_page_is_displayed(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/sell');

        $response->assertStatus(200);
    }

    public function test_user_can_create_item_with_all_required_fields(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create(['name' => '家電']);

        $image = UploadedFile::fake()->image('item.jpg');

        $response = $this->post('/sell', [
            'name' => 'iPhone 15 Pro',
            'brand' => 'Apple',
            'description' => 'ほぼ新品のiPhone 15 Proです。',
            'price' => 150000,
            'condition' => '良好',
            'category_ids' => (string)$category->id,
            'image' => $image,
        ]);

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'iPhone 15 Pro',
            'description' => 'ほぼ新品のiPhone 15 Proです。',
            'price' => 150000,
            'condition' => '良好',
        ]);

        $item = Item::where('name', 'iPhone 15 Pro')->first();
        $this->assertTrue($item->categories->contains($category));
    }
}