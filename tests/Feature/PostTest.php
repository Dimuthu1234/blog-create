<?php

namespace Tests\Feature;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSearch()
    {
        $user = User::first();
        $this->actingAs($user);

        $post = Post::create([
            'title' => 'dimuthu search test',
            'description' => 'this is the description'
        ]);
        $comment = new Comment(['comment' => 'test comment dimuthu']);
        $post->comments()->save($comment);
        $response = $this->post('/post/search', ['search' => 'dimu']);
        $response->assertStatus(200);
    }
}
