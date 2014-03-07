<?php

namespace Lablog\Lablog\Controllers;

use Lablog\Lablog\Post\PostGatewayInterface;
use Stringy\Stringy;

class CategoryController extends \BaseController
{

    public function __construct(PostGatewayInterface $post, \Illuminate\Filesystem\Filesystem $fs)
    {
        $this->post = $post;
        $this->fs = $fs;
    }

    /**
     * Show a category.
     * @param  string $category The category to show.
     * @return \View
     */
    public function showCategory($category)
    {
        $ds = DIRECTORY_SEPARATOR;
        $categoryPath = str_replace('/', $ds, $category);

        $fullCategoryPath = app_path().$ds.'lablog'.$ds.$categoryPath;

        if (!$this->fs->isDirectory($fullCategoryPath)) {
            return \App::abort('404');
        }

        $posts = $this->post->getAll($fullCategoryPath);

        $allPosts = array();

        $linkPrefix = \Config::get('lablog::prefix') == '/' ? '' : \Config::get('lablog::prefix');

        $categoryExplode = explode('/', $category);
        $categoryName = end($categoryExplode);

        $categoryCount = count($categoryExplode);

        if ($categoryCount > 1) {
            $parent = $categoryExplode[$categoryCount-2];
            $categoryPathExplode = explode($parent, $category);
            $categoryPath = $categoryPathExplode[0].'/'.$parent;
            $link = $linkPrefix.'/category'.$categoryPath;
            $parentCategory = array(
                'name' => $parent,
                'url' => \URL::to($link),
                'link' => $categoryPath
            );
        } else {
            $parentCategory = '';
        }

        foreach ($posts as $post) {
            $explodePath = explode('/', $post);
            $postName = str_replace('.post', '', end($explodePath));

            $link = $linkPrefix.'/post/'.$category.'/'.$postName;
            $allPosts[] = array(
                'name' => $postName,
                'url' => \URL::to($link),
                'link' => $category.'/'.$postName
            );
        }

        $theme = \Config::get('lablog::theme');

        return \View::make($theme.'.category', array(
            'posts' => $allPosts,
            'parent' => $parentCategory,
            'path' => $category
        ));
    }
}