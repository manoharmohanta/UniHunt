<?php

namespace App\Controllers\Api;

use App\Models\BlogModel;

class BlogController extends ApiController
{
    public function index()
    {
        $blogModel = new BlogModel();
        $blogs = $blogModel
            ->where('status', 'published')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->success($blogs);
    }

    public function show($id = null)
    {
        $blogModel = new BlogModel();
        $blog = $blogModel->find($id);

        if (!$blog) {
            return $this->error('Blog post not found', 404);
        }

        return $this->success($blog);
    }
}
