<?php

namespace Lablog\Lablog\Controllers;

class BlogController extends \BaseController
{
    /**
     * Show the blog home page.
     * @return \View
     */
    public function showHome()
    {
        echo 'Blog Home Page.';
    }
}