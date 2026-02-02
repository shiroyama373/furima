<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_post_comment(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();

        $initialCommentCount = $item->comments()->count();

        $response = $this->post("/items/{$item->id}/comment", [
            'comment' => 'これはテストコメントです。',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'これはテストコメントです。',
        ]);

        $this->assertEquals($initialCommentCount + 1, $item->fresh()->comments()->count());
    }

    public function test_unauthenticated_user_cannot_post_comment(): void
    {
        $item = Item::factory()->create();

        $response = $this->post("/items/{$item->id}/comment", [
            'comment' => 'これはテストコメントです。',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'comment' => 'これはテストコメントです。',
        ]);
    }

    public function test_validation_error_when_comment_is_empty(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();

        $response = $this->post("/items/{$item->id}/comment", [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors('comment');
    }

    public function test_validation_error_when_comment_exceeds_255_characters(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();

        $longComment = str_repeat('あ', 256);

        $response = $this->post("/items/{$item->id}/comment", [
            'comment' => $longComment,
        ]);

        $response->assertSessionHasErrors('comment');
    }
}