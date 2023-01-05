<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;

class PostTest extends TestCase
{
    use RefreshDatabase;


    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function un_post_puede_ser_creado()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/posts',[
            'userId' => '12312',
            'title' => 'titulo ejemplo',
            'body' => 'body ejemplo'
        ]);
        $response->assertStatus(200);
        $this->assertCount(1, Post::all());

        $post = Post::first();
        $this->assertEquals($post->userId,'12312');
        $this->assertEquals($post->title,'titulo ejemplo');
        $this->assertEquals($post->body,'body ejemplo');

    }

     /** @test */
    public function que_se_pueda_eliminar_toda_la_tabla()
    {
        $this->withoutExceptionHandling();
        $post = $this->post('/api/posts',[
            'userId' => '12312',
            'title' => 'titulo ejemplo',
            'body' => 'body ejemplo'
        ]);

        $response = $this->json('DELETE',route('api.delete'));

        $this->assertCount(0, Post::all());




    }

}
