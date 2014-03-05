<?php

namespace Lablog\Lablog\Page;

class FilePage implements PageGatewayInterface
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
     * Check that a page exists.
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
     * Get the full contents of a page.
     * @param  string $path
     * @return string
     */
    public function get($path)
    {
        return $this->fs->get($path);
    }

    /**
     * Get the last time the page was modified.
     * @param string $path
     * @return string
     */
    public function modified($path)
    {
        return $this->fs->lastModified($path);
    }
}