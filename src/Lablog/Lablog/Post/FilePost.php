<?php

namespace Lablog\Lablog\Post;
use Illuminate\Filesystem\Filesystem;
use Lablog\Lablog\Processor\ProcessorInterface;

class FilePost implements PostGatewayInterface
{
    public $fs;

    /**
     * Inject the laravel filesystem.
     * @param IlluminateFilesystemFilesystem $fs
     */
    public function __construct(
        Filesystem $fs,
        PostConfigGatewayInterface $config,
        ProcessorInterface $processor)
    {
        $this->fs = $fs;
        $this->config = $config;
        $this->processor = $processor;
    }

    /**
     * Check that a post exists.
     * @param  string $path
     * @return boolean
     */
    public function exists($category, $post)
    {
        $ds = DIRECTORY_SEPARATOR;
        $postPath = str_replace('/', $ds, $category.$ds.$post);

        $fullPostPath = app_path().$ds.'lablog'.$ds.$postPath.'.post';

        if ($this->fs->exists($fullPostPath)) {
            return true;
        }

        return false;
    }

    public function getPost($category, $postName)
    {
        $ds = DIRECTORY_SEPARATOR;
        $postPath = str_replace('/', $ds, $category.$ds.$postName);

        $fullPostPath = app_path().$ds.'lablog'.$ds.$postPath.'.post';

        if (!$this->exists($category, $postName)) {
            return false;
        }

        $postContent = $this->fs->get($fullPostPath);

        $configWrap = \Config::get('lablog::post.configWrap') ?: '{POSTCONFIG}';

        $postContent = $this->config->strip($postContent, $configWrap);

        $config = $this->config->decode($postContent['config']);

        if (isset($config->title)) {
            $name = $config->title;
        } else {
            $name = $postName;
        }

        if (isset($config->content)) {
            $content = $config->content;
        } else {
            $content = $postContent['content'];
        }

        if (isset($config->modified)) {
            $modified = $config->modified;
        } else {
            $modified = $this->modified($fullPostPath);
        }

        $linkPrefix = \Config::get('lablog::prefix');

        $url = $linkPrefix.$category.'/'.$postName;

        $post = new Post;
        $post->name = $name;
        $post->modified = $modified;
        $post->url = \URL::to($url);
        $post->category = $category;
        $post->content = $this->processor->process($content);
        $post->link = $category.'/'.$postName;
        $post->config = $config;

        return $post;
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
    public function getAll($category)
    {
        $ds = DIRECTORY_SEPARATOR;

        $category = str_replace('/', $ds, $category);

        $path = app_path().$ds.'lablog'.$ds.$category;

        $posts = $this->fs->files($path);

        $allPosts = array();

        foreach ($posts as $post) {
            if (strpos($post, '.post') === false) {
                continue;
            }
            $postPath = str_replace('.post', '', $post);
            $allPosts[$this->modified($post).rand()] = str_replace($path, '', $postPath);
        }

        arsort($allPosts);

        $posts = array();

        foreach ($allPosts as $post) {
            $categoryExplode = explode($ds, $post);
            $post = array_pop($categoryExplode);
            $posts[] = $this->getPost($category, $post);
        }

        return $posts;
    }

    public function findAll($path = '')
    {
        $ds = DIRECTORY_SEPARATOR;

        $basePath = app_path().$ds.'lablog'.$ds;

        $path = app_path().$ds.'lablog'.$ds.$path;

        $posts = $this->fs->allFiles($path);

        foreach ($posts as $post) {
            if (strpos($post, '.post') === false) {
                continue;
            }
            $postPath = str_replace('.post', '', $post);
            $allPosts[$this->modified($post).rand()] = str_replace($path, '', $postPath);
        }

        arsort($allPosts);

        $posts = array();

        foreach ($allPosts as $post) {
            $categoryExplode = explode('/', $post);
            $post = array_pop($categoryExplode);
            $category = str_replace($basePath, '', implode('/', $categoryExplode));
            $posts[] = $this->getPost($category, $post);
        }

        return $posts;
    }
}