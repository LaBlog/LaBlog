<?php

namespace Lablog\Lablog\Controllers;

use Lablog\Lablog\Post\PostGatewayInterface;
use Lablog\Lablog\Category\CategoryGatewayInterface;
use Stringy\Stringy;

class CategoryController extends \BaseController
{

    public function __construct(
        PostGatewayInterface $post,
        \Illuminate\Filesystem\Filesystem $fs,
        CategoryGatewayInterface $category)
    {
        $this->post = $post;
        $this->fs = $fs;
        $this->category = $category;
    }

    public function showCategories()
    {
        $subCategories = $this->category->getSubCategories('');
        foreach ($subCategories as $blogCategory) {
            $category = $this->category->getCategory($blogCategory->link);
            $category->posts = $this->category->getCategoryPosts($blogCategory->link);
        }

        $theme = \Config::get('lablog::theme');
        $global = \Config::get('lablog::global');

        if (!isset($category->name)) {
            return \Response::view($theme.'.404', array(
                'global' => $global,
                'error_message' => 'Sorry, the Category could not be found.'
            ), 200);
        }

        return \View::make($theme.'.category', array(
            'category' => $category,
            'subCategories' => $subCategories,
            'global' => $global
        ));
    }

    /**
     * Show a category.
     * @param  string $category The category to show.
     * @return \View
     */
    public function showCategory($category, $pagenumber = 1)
    {
        $fullCategory = $category;
        $subCategories = $this->category->getSubCategories($category);
        $category = $this->category->getCategory($category);
        $category->posts = $this->category->getCategoryPosts($fullCategory);

        $theme = \Config::get('lablog::theme');
        $global = \Config::get('lablog::global');

        if (!isset($category->name)) {
            return \Response::view($theme.'.404', array(
                'global' => $global,
                'error_message' => 'Sorry, the Category could not be found.'
            ), 200);
        }

        return \View::make($theme.'.category', array(
            'category' => $category,
            'subCategories' => $subCategories,
            'pageNumber' => $pagenumber,
            'global' => $global
        ));
    }
}