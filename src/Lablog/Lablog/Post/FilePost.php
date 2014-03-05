<?php

namespace Lablog\Lablog\Post;

class FilePost implements PostGatewayInterface
{
    private $fs;

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
        return $this->fs->allFiles($path);
    }
}