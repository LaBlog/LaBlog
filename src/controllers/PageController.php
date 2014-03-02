<?php

namespace Lablog\Lablog\Controllers;

class PageController extends \BaseController
{
    /**
     * Show a single requested page.
     * @param  string $pageName The name of the page to show.
     * @return \View
     */
    public function showPage($pageName)
    {
        echo 'page';
    }
}