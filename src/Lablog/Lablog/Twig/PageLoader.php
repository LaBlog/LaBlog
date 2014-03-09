<?php

namespace Lablog\Lablog\Twig;

use Twig_Environment;
use Twig_Function_Function;
use Twig_Function_Method;
use Twig_Filter_Method;
use Twig_Extension;

class PageLoader extends Twig_Extension
{
    /**
     * Get the page type being used.
     * @return void
     */
    public function __construct()
    {
        $page = \App::make('Lablog\Lablog\Page\PageGatewayInterface');
        $this->page = $page;
    }

    /**
     * Return the name of the object.
     * @return string
     */
    public function getName()
    {
        return 'PageLoader';
    }

    /**
     * Register the plugins twig functions.
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'page' => new Twig_Function_Method($this, 'page'),
        );
    }

    /**
     * Return a single page object on request.
     * @param  string $pageName
     * @return \Lablog\Lablog\Page\Page
     */
    public function page($pageName)
    {
        return $this->page->get($pageName);
    }
}