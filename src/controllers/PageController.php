<?php

namespace Lablog\Lablog\Controllers;

use Lablog\Lablog\Page\PageGatewayInterface;
use Lablog\Lablog\Page\PageConfigGatewayInterface;
use Lablog\Lablog\Page\Page;
use Lablog\Lablog\Processor\ProcessorInterface;
use Stringy\StringyStatic as Stringy;

class PageController extends \BaseController
{
    public function __construct(
        PageGatewayInterface $page,
        PageConfigGatewayInterface $pageConfig,
        ProcessorInterface $processor)
    {
        $this->page = $page;
        $this->pageConfig = $pageConfig;
        $this->processor = $processor;
    }

    /**
     * Show a single requested page.
     * @param  string $pageName The name of the page to show.
     * @return \View
     */
    public function showPage($pageName = 'index')
    {
        $ds = DIRECTORY_SEPARATOR;

        $fullPagePath = app_path().$ds.'lablog'.$ds.$pageName.'.page';

        if ($this->page->exists($fullPagePath)) {
            $pageContent = $this->page->get($fullPagePath);

            $configWrap = \Config::get('lablog::page.configWrap') ?: '{POSTCONFIG}';

            $pageContent = $this->pageConfig->strip($pageContent, $configWrap);

            $config = $this->pageConfig->decode($pageContent['config']);

            if (isset($config->title)) {
                $name = $config->title;
            } else {
                $name = $pageName;
            }

            if (isset($config->content)) {
                $content = $config->content;
            } else {
                $content = $pageContent['content'];
            }

            if (isset($config->modified)) {
                $modified = $config->modified;
            } else {
                $modified = $this->page->modified($fullPagePath);
            }

            $page = new Page;
            $page->name = $name;
            $page->modified = $modified;
            $page->content = $this->processor->process($content);
            $page->path = $fullPagePath;

            $template = \Config::get('lablog::theme');
            $extra = \Config::get('lablog::global');

            $templateFile = $pageName == 'index' ? 'home' : 'page';

            return \View::make($template.'.'.$templateFile, array(
                'page' => $page,
                'config' => $config,
                'global' => $extra
            ));

        } else {
            $extra = \Config::get('lablog::extra.page');
            $message = isset($extra['notFound']) ? $extra['notFound'] : 'Page not found.';
            return \App::abort(404, $message);
        }
    }
}