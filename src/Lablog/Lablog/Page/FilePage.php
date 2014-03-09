<?php

namespace Lablog\Lablog\Page;
use Lablog\Lablog\Page\PageConfigGatewayInterface;
use Lablog\Lablog\Processor\ProcessorInterface;

class FilePage implements PageGatewayInterface
{
    private $fs;
    private $config;

    /**
     * Inject the laravel filesystem.
     * @param IlluminateFilesystemFilesystem $fs
     */
    public function __construct(
        \Illuminate\Filesystem\Filesystem $fs,
        PageConfigGatewayInterface $config,
        ProcessorInterface $processor)
    {
        $this->fs = $fs;
        $this->config = $config;
        $this->processor = $processor;
    }

    /**
     * Check that a page exists.
     * @param  string $path
     * @return boolean
     */
    public function exists($pageName)
    {
        $ds = DIRECTORY_SEPARATOR;
        $path = app_path().$ds.'lablog'.$ds.$pageName.'.page';

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
    public function get($pageName)
    {
        $ds = DIRECTORY_SEPARATOR;
        $path = app_path().$ds.'lablog'.$ds.$pageName.'.page';

        $pageContent = $this->fs->get($path);

        $page = $this->config->strip($pageContent, '{PAGECONFIG}');

        $pageObject = new Page;
        $pageObject->name = $pageName;
        $pageObject->modified = $this->modified($path);
        $pageObject->content = $this->processor->process($page['content']);
        $pageObject->config = $page['config'];
        $pageObject->slug = $pageName;
        $pageObject->url = \URL::to(\Config::get('lablog::config.prefix').'/'.$pageName);

        return $pageObject;
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