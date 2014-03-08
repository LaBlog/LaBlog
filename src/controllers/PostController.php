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
    public function __construct(
        PostGatewayInterface $post,
        PostConfigGatewayInterface $postConfig,
        ProcessorInterface $processor,
        CategoryGatewayInterface $category)
    {
        $this->post = $post;
        $this->postConfig = $postConfig;
        $this->processor = $processor;
        $this->category = $category;
    }

    /**
     * Show all of the posts.
     * @return \View
     */
    public function showPosts($pagenumber = 1)
    {
        $posts = $this->post->findAll();

        $theme = \Config::get('lablog::theme');
        $extra = \Config::get('lablog::global');

        return \View::make($theme.'.posts', array(
            'posts' => $posts,
            'pageNumber' => $pagenumber,
            'global' => $extra
        ));
    }

    /**
     * Show a single post.
     * @param string $postName The name of the post to retrieve.
     * @return \View
     */
    public function showPost($category, $postName)
    {
        $ds = DIRECTORY_SEPARATOR;
        $postPath = str_replace('/', $ds, $category.'/'.$postName);

        $fullPostPath = app_path().$ds.'lablog'.$ds.$postPath.'.post';

        $post = $this->post->getPost($category, $postName);

        if ($post) {

            $fullCategory = $this->category->getCategory($category);

            $template = \Config::get('lablog::theme');
            $extra = \Config::get('lablog::global');

            return \View::make($template.'.post', array(
                'post' => $post,
                'global' => $extra,
                'category' => $fullCategory
            ));

        } else {
            $template = \Config::get('lablog::theme');
            $global = \Config::get('lablog::global');
            return \Response::view($template.'.404', array(
                'global' => $global,
                'error_message' => 'Sorry, the Post could not be found.'
            ), 200);
        }
    }
}