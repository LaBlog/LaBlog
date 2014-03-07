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

        return \View::make($theme.'.category', array(
            'category' => $category,
            'subCategories' => $subCategories,
            'pageNumber' => $pagenumber
        ));
    }
}