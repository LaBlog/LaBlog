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
    public function exists($category)
    {
        $ds = DIRECTORY_SEPARATOR;
        $path = app_path().$ds.'lablog'.$ds.$category;

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

        if (!$this->exists($category)) {
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

        if (!$this->exists($category)) {
            return (object) array();
        }

        $categoryExplode = explode('/', $category);
        $categoryName = end($categoryExplode);

        $linkPrefix = \Config::get('lablog::prefix') == '/' ? '' : \Config::get('lablog::prefix');

        $baseCategory = $category;
        $categoryLink = $linkPrefix.'/category/'.$category;
        $fullCategory = $category;

        $category = new Category;
        $category->name = $categoryName;
        $category->link = $baseCategory;
        $category->url = \URL::to($categoryLink);

        return $category;
    }

    public function getParentCategory($category)
    {
        if (!$this->exists($category)) {
            return (object) array();
        }

        $categoryExplode = explode('/', $category);

        $categoryCount = count($categoryExplode);

        if ($categoryCount > 1) {
            array_pop($categoryExplode);

            $parentCategory = implode('/', $categoryExplode);

            $parent = $this->getCategory($parentCategory);

        } else {
            $parent = '';
        }

        return $parent;
    }
}