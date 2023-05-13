<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->authUser();
    }

    public function test_it_store_post()
    {
        $this->authUser();
        $response = $this->post('api/c/testercommunity/post/submit',
        [
            'title' => 'TestPost',
            'text' => 'Testtextinpost',
        ]);
        $response->assertStatus(201);

    }

    public function test_it_edit_post()
    {
        $this->createPost(['user_id'=> auth()->id(), 'id'=>'999']);
        $responce = $this->put('api/post/999/edit',
        [
            'title' => 'Pepega',
            'text' => 'Sadge',
        ]);
        $responce->assertStatus(200);
    }

    public function test_it_delete_post()
    {
        $this->createPost(['user_id'=> auth()->id(), 'id'=>'998']);
        $responce = $this->delete('api/post/998/delete');
        
        $responce->assertStatus(200);
    }
}
