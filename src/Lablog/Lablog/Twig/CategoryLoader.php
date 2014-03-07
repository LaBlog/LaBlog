<?php

namespace Lablog\Lablog\Twig;

use Twig_Environment;
use Twig_Function_Function;
use Twig_Function_Method;
use Twig_Filter_Method;
use Twig_Extension;
use Illuminate\Filesystem\Filesystem;

class CategoryLoader extends Twig_Extension
{
    public function __construct()
    {
        $mode = \Config::get('lablog::mode');

        $categoryConfigGateway = 'Lablog\Lablog\Category\\'.ucfirst($mode).'Category';

        $this->category = new $categoryConfigGateway(new Filesystem);
    }

    public function getName()
    {
        return 'CategoryLoader';
    }

    public function getFunctions()
    {
        return array(
            'getCategoryPosts' => new Twig_Function_Method($this, 'getCategoryPosts'),
            'getSubCategories' => new Twig_Function_Method($this, 'getSubCategories')
        );
    }

    public function getCategoryPosts($category)
    {
        return $this->category->getCategoryPosts($category);
    }

    public function getSubCategories($category)
    {
        return $this->category->getSubCategories($category);
    }
}