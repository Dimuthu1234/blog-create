<?php

namespace Tests\Feature;

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
//    public function testExample()
//    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSearch()
    {
        $user = User::first();
        $this->actingAs($user);
        $response = $this->call('post', '/post/search');
        $response->assertStatus(200);
    }
}
