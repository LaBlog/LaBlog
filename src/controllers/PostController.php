<?php

namespace Lablog\Lablog\Controllers;

class PostController extends \BaseController
{
    public function __construct()
    {
        $app = app();
        $this->post = $app['lablog']->post;
    }

    /**
     * Show all of the posts.
     * @return \View
     */
    public function showPosts()
    {
        echo 'All posts.';
    }

    /**
     * Show a single post.
     * @param string $postName The name of the post to retrieve.
     * @return \View
     */
    public function showPost($category, $postName)
    {
        $path = $category.'/'.$postName;
        $post = $this->post->getPost($path);

        
    }
}