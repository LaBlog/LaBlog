<?php

namespace Lablog\Lablog\Post;

class FilePost implements PostGatewayInterface
{
    public $fs;

    /**
     * Inject the laravel filesystem.
     * @param IlluminateFilesystemFilesystem $fs
     */
    public function __construct(\Illuminate\Filesystem\Filesystem $fs)
    {
        $this->fs = $fs;
    }

    /**
     * Check that a post exists.
     * @param  string $path
     * @return boolean
     */
    public function exists($path)
    {
        if ($this->fs->exists($path)) {
            return true;
        }

        return false;
    }

    /**
     * Get the full contents of a post.
     * @param  string $path
     * @return string
     */
    public function get($path)
    {
        return $this->fs->get($path);
    }

    /**
     * Get the last time the post was modified.
     * @param string $path
     * @return string
     */
    public function modified($path)
    {
        return $this->fs->lastModified($path);
    }

    /**
     * Get all files from the blog of specified category.
     * @param  string $path
     * @return string
     */
    public function getAll($path)
    {
        return $this->fs->files($path);
    }

    public function findAll()
    {
        $ds = DIRECTORY_SEPARATOR;

        $path = app_path().$ds.'lablog/';

        $posts = $this->fs->allFiles($path);

        $linkPrefix = \Config::get('lablog::prefix') == '/' ? '' : \Config::get('lablog::prefix');

        foreach ($posts as $post) {
            if (strpos($post, '.post') === false) {
                continue;
            }
            $postPath = str_replace('.post', '', $post);
            $allPosts[] = str_replace($path, '', $postPath);
        }

        $posts = array();

        foreach ($allPosts as $post) {
            $explodePath = explode('/', $post);
            $postName = end($explodePath);

            $category = $explodePath[count($explodePath) - 2];

            $path = $post;
            $categoryPath = str_replace($postName, '', $path);

            $link = $linkPrefix.'/post/'.$path;
            $categoryLink = $linkPrefix.'/category/'.$categoryPath;

            $postDetails = new Post;
            $postDetails->name = $postName;
            $postDetails->url = \URL::to($link);
            $postDetails->link = $link;
            $postDetails->category = array(
                'name' => $category,
                'url' => \URL::to($categoryLink),
                'link' => $categoryLink
            );

            $posts[] = $postDetails;
        }

        return $posts;
    }
}