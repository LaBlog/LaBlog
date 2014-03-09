<?php

namespace Lablog\Lablog\Controllers;

use Lablog\Lablog\Page\PageGatewayInterface;
use Lablog\Lablog\Processor\ProcessorInterface;

class PageController extends \BaseController
{
    public function __construct(PageGatewayInterface $page)
    {
        $this->theme = \Config::get('lablog::theme');
        $this->global = \Config::get('lablog::global');

        $this->page = $page;
    }

    /**
     * Show a single requested page.
     * @param  string $pageName The name of the page to show.
     * @return \View
     */
    public function showPage($pageName = 'index')
    {
        if (!$this->page->exists($pageName)) {
            return \Response::view($this->theme.'.404', array('global' => $this->global), 404);
        }

        $page = $this->page->get($pageName);

        $viewParamaters = array(
            'global' => $this->global,
            'page' => $page
        );

        if (\View::exists($this->theme.'.'.$pageName)) {
            return \View::make($this->theme.'.'.$pageName, $viewParamaters);
        } else {
            return \View::make($this->theme.'.page', $viewParamaters);
        }
    }
}