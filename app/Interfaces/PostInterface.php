<?php

namespace App\Interfaces;

use App\Http\Requests\PostRequest;

interface PostInterface
{
    /**
     * Get all post
     *
     * @method  GET api/post
     * @access  public
     */
    public function getAllPost();

    /**
     * Get Post By ID
     *
     * @param   integer     $id
     *
     * @method  GET api/post/{id}
     * @access  public
     */
    public function getPostById($id);



    /**
     * Delete post
     *
     * @param   integer     $id
     *
     * @method  DELETE  api/post/{id}
     * @access  public
     */
    public function deletePost($id);

    public function generatePdfAllPost();

    public function store(PostRequest $request);

    public function update(PostRequest $request, $id);

    public function deleteAllPost();

}
