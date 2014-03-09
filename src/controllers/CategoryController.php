<?php

namespace Lablog\Lablog\Controllers;

use Lablog\Lablog\Post\PostGatewayInterface;
use Lablog\Lablog\Category\CategoryGatewayInterface;
use Stringy\Stringy;

class CategoryController extends \BaseController
{

    public function __construct(
        PostGatewayInterface $post,
        CategoryGatewayInterface $category)
    {
        $this->theme = \Config::get('lablog::theme');
        $this->global = \Config::get('lablog::global');

        $this->post = $post;
        $this->category = $category;
    }

    public function showCategories()
    {
        $categories = $this->category->getSubCategories('');

        $viewParamaters = array(
            'global' => $this->global,
            'categories' => $categories
        );

        return \View::make($this->theme.'.categories', $viewParamaters);
    }

    /**
     * Show a category.
     * @param  string $category The category to show.
     * @return \View
     */
    public function showCategory($category, $pagenumber = 1)
    {
        if (!$this->category->exists($category)) {
            return \Response::view($this->theme.'.404', array('global' => $this->global), 404);
        }

        $categoryObject = $this->category->getCategory($category);
        $parent = $this->category->getParentCategory($category);
        $subCategories = $this->category->getSubCategories($category);
        $posts = $this->post->getAll($category);

        $viewParamaters = array(
            'global' => $this->global,
            'category' => $categoryObject,
            'parent' => $parent,
            'subCategories' => $subCategories,
            'posts' => $posts,
            'pageNumber' => $pagenumber
        );

        return \View::make($this->theme.'.category', $viewParamaters);
    }
}