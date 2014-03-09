<?php

namespace Lablog\Lablog\Controllers;

use Lablog\Lablog\Post\PostGatewayInterface;
use Lablog\Lablog\Post\PostConfigGatewayInterface;
use Lablog\Lablog\Post\Post;
use Lablog\Lablog\Category\CategoryGatewayInterface;
use Lablog\Lablog\Processor\ProcessorInterface;
use Stringy\StringyStatic as Stringy;

class PostController extends \BaseController
{
    public function __construct(PostGatewayInterface $post, CategoryGatewayInterface $category)
    {
        $this->theme = \Config::get('lablog::theme');
        $this->global = \Config::get('lablog::global');

        $this->post = $post;
        $this->category = $category;
    }

    /**
     * Show all of the posts.
     * @return \View
     */
    public function showPosts($pagenumber = 1)
    {
        $posts = $this->post->findAll();

        $viewParamaters = array(
            'global' => $this->global,
            'posts' => $posts
        );

        return \View::make($this->theme.'.posts', $viewParamaters);
    }

    /**
     * Show a single post.
     * @param string $postName The name of the post to retrieve.
     * @return \View
     */
    public function showPost($category, $postName)
    {
        if (!$this->post->exists($category, $postName)) {
            return \Response::view($this->theme.'.404', array('global' => $this->global), 404);
        }

        $post = $this->post->getPost($category, $postName);
        $category = $this->category->getCategory($category);

        $viewParamaters = array(
            'post' => $post,
            'global' => $this->global
        );

        return \View::make($this->theme.'.post', $viewParamaters);
    }
}