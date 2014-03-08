<?php

namespace Lablog\Lablog\Category;

class FileCategory implements CategoryGatewayInterface
{
    /**
     * Inject the laravel filesystem.
     * @param IlluminateFilesystemFilesystem $fs
     */
    public function __construct(\Illuminate\Filesystem\Filesystem $fs)
    {
        $this->fs = $fs;
    }

    /**
     * Check if a given category exists or not.
     * @param  string $path
     * @return boolean
     */
    public function exists($path)
    {
        if ($this->fs->isDirectory($path)) {
            return true;
        }

        return false;
    }

    /**
     * Get a given categories sub categories.
     * @param  string $category
     * @return array
     */
    public function getSubCategories($category)
    {
        $ds = DIRECTORY_SEPARATOR;
        $categoryPath = str_replace('/', $ds, $category);

        $basePath = app_path().$ds.'lablog'.$ds;

        $path = $basePath.$categoryPath;

        if (!$this->exists($path)) {
            return array();
        }

        $categories = $this->fs->directories($path);

        $allCategories = array();

        foreach ($categories as $category) {
            $cat = str_replace($basePath, '', $category);
            $allCategories[] = $this->getCategory($cat);
        }

        return $allCategories;
    }

    /**
     * Get a given category information.
     * @param  string $category
     * @return void
     */
    public function getCategory($category)
    {
        $ds = DIRECTORY_SEPARATOR;
        $categoryPath = str_replace('/', $ds, $category);

        $path = app_path().$ds.'lablog'.$ds.$categoryPath;

        if (!$this->exists($path)) {
            return (object) array();
        }

        $linkPrefix = \Config::get('lablog::prefix') == '/' ? '' : \Config::get('lablog::prefix');

        $categoryExplode = explode('/', $category);
        $categoryName = end($categoryExplode);

        $categoryCount = count($categoryExplode);

        if ($categoryCount > 1) {
            $parent = $categoryExplode[$categoryCount-2];
            $categoryPathExplode = explode($parent, $category);
            $categoryPath = $categoryPathExplode[0].'/'.$parent;
            $link = $linkPrefix.'/category'.$categoryPath;
            $parentCategory = new Category;
            $parentCategory->name = $parent;
            $parentCategory->url = \URL::to($link);
            $parentCategory->link = $categoryPath;
        } else {
            $parentCategory = '';
        }

        $baseCategory = $category;
        $categoryLink = $linkPrefix.'/category/'.$category;
        $fullCategory = $category;

        $category = new Category;
        $category->parent = $parentCategory;
        $category->name = $categoryName;
        $category->link = $baseCategory;
        $category->url = \URL::to($categoryLink);

        return $category;
    }

    /**
     * Get all of the posts in a category.
     * @param  string $category
     * @return array
     */
    public function getCategoryPosts($category)
    {
        $ds = DIRECTORY_SEPARATOR;
        $categoryPath = str_replace('/', $ds, $category);

        $path = app_path().$ds.'lablog'.$ds.$categoryPath;

        if (!$this->exists($path)) {
            return array();
        }

        $posts = $this->fs->files($path);

        $allPosts = array();

        $linkPrefix = \Config::get('lablog::prefix') == '/' ? '' : \Config::get('lablog::prefix');

        foreach ($posts as $post) {
            if (strpos('.post', $post) === false) {
                continue;
            }
            $explodePath = explode('/', $post);
            $postName = str_replace('.post', '', end($explodePath));

            $link = $linkPrefix.'/post/'.$category.'/'.$postName;
            $allPosts[] = array(
                'name' => $postName,
                'url' => \URL::to($link),
                'link' => $category.'/'.$postName
            );
        }

        return $allPosts;
    }

    /**
     * Get all posts in a category, including sub categories.
     * @param  string $category
     * @return array
     */
    public function getAllCategoryPosts($category)
    {
        $ds = DIRECTORY_SEPARATOR;
        $categoryPath = str_replace('/', $ds, $category);

        $path = app_path().$ds.'lablog'.$ds.$categoryPath;

        if (!$this->exists($path)) {
            return array();
        }

        $posts = $this->fs->allFiles($path);

        $allPosts = array();

        $linkPrefix = \Config::get('lablog::prefix') == '/' ? '' : \Config::get('lablog::prefix');

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

        return $allPosts;
    }
}