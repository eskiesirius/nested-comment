<?php

namespace Tests\Feature;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_cant_create_comment_if_no_name_field()
    {
        $response = $this->post(route('comments.store'),[
            'name'          => null,
            'body'          => 'body',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function test_cant_create_comment_if_no_body_field()
    {
        $response = $this->post(route('comments.store'),[
            'name'          => 'name',
            'body'          => null,
        ]);

        $response->assertSessionHasErrors('body');
    }

    /** @test */
    public function test_can_create_comment()
    {
        $response = $this->post(route('comments.store'),[
            'name'          => 'name',
            'body'          => 'body',
        ]);

        $this->assertDatabaseHas('comments',[
            'parent_id'     => null,
            'name'          => 'name',
            'body'          => 'body',
            'depth'         => 0
        ]);
    }

    /** @test */
    public function test_cant_reply_comment_if_no_name_field()
    {
        $comment = Comment::factory()->create();

        $response = $this->post(route('comments.reply',['comment' => $comment]),[
            'name'          => null,
            'body'          => 'body',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function test_cant_reply_comment_if_no_body_field()
    {
        $comment = Comment::factory()->create();

        $response = $this->post(route('comments.reply',['comment' => $comment]),[
            'name'          => 'name',
            'body'          => null,
        ]);

        $response->assertSessionHasErrors('body');
    }

    /** @test */
    public function test_cant_reply_comment_if_depth_is_above_two()
    {
        $comment = Comment::factory()->create([
            'depth' => 2
        ]);

        $response = $this->post(route('comments.reply',['comment' => $comment]),[
            'name'          => 'name',
            'body'          => 'body',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_can_reply_main_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->post(route('comments.reply',['comment' => $comment]),[
            'name'          => 'name',
            'body'          => 'body',
        ]);

        $this->assertDatabaseHas('comments',[
            'parent_id'     => $comment->id,
            'name'          => 'name',
            'body'          => 'body',
            'depth'         => 1
        ]);
    }

    /** @test */
    public function test_can_reply_second_layer_comment()
    {
        $comment = Comment::factory()->create([
            'depth' => 1
        ]);

        $response = $this->post(route('comments.reply',['comment' => $comment]),[
            'name'          => 'name',
            'body'          => 'body',
        ]);

        $this->assertDatabaseHas('comments',[
            'parent_id'     => $comment->id,
            'name'          => 'name',
            'body'          => 'body',
            'depth'         => 2
        ]);
    }
}
