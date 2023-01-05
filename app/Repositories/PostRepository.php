<?php

namespace App\Repositories;

use App\Http\Requests\PostRequest;
use App\Interfaces\PostInterface;
use App\Traits\ResponseAPI;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PostRepository implements PostInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllPost()
    {
        try {
            $posts = Post::all();
            return $this->success("All Post", $posts);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function generatePdfAllPost(): Collection
    {
        try {
            $posts = Post::get();
            return $posts;
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getPostById($id)
    {
        try {
            $post = Post::find($id);

            // Check the post
            if(!$post) return $this->error("No post with ID $id", 404);

            return $this->success("Post Detail", $post);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        DB::beginTransaction();
        try {
            $post = new Post;
            $post->fill($request->validated())->save();
            DB::commit();
            return $this->success("Post created", $post,200);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function update(PostRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $post = Post::find($id);
            if(!$post) return $this->error("No post with ID $id", 404);
            $post->fill($request->validated())->save();
            DB::commit();
            return $this->success(
                "Post updated",
                $post, 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }


    public function deletePost($id)
    {
        DB::beginTransaction();
        try {
            $post = Post::find($id);

            // Check the post
            if(!$post) return $this->error("No posts with ID $id", 404);

            // Delete the post
            $post->delete();

            DB::commit();
            return $this->success("Post deleted", $post);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteAllPost()
    {

        try {
            $post = Post::truncate();
            return $this->success("all Post deleted", $post);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
