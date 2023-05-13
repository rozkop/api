<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use SebastianBergmann\Type\VoidType;
use Tests\TestCase;

class CommunityTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->authUser();
    }

    public function test_it_store_community()
    {
        $this->authUser();
        $response = $this->post('api/c/create',
        [
            'name' => 'TesterCommunity',
            'description' => 'TestDescription',
        ]);
        $response->assertStatus(201);

    }

    public function test_it_delete_community()
    {
        $this->createCommunity(['name'=> 'deletetest','user_id'=> auth()->id()]);
        $responce = $this->delete('api/c/deletetest/delete');
        $responce->assertStatus(200);
    }

    public function test_it_edit_community()
    {
        $this->createCommunity(['name'=> 'edittest','user_id'=> auth()->id()]);
        $responce = $this->put('api/c/edittest/edit',
        [
            'name' => 'Road roller!',
            'description' => 'Reeeeeeeeeeeeeee',
        ]);
        
        $responce->assertStatus(200);
    }
}
