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
        $categoryGatewayInterface = \Config::get('lablog::bindings.Lablog\Lablog\Category\CategoryGatewayInterface');

        $this->category = new $categoryGatewayInterface(new Filesystem);
    }

    public function getName()
    {
        return 'CategoryLoader';
    }

    public function getFunctions()
    {
        return array(
            'getCategoryPosts' => new Twig_Function_Method($this, 'getCategoryPosts'),
            'getSubCategories' => new Twig_Function_Method($this, 'getSubCategories'),
            'getAllCategoryPosts' => new Twig_Function_Method($this, 'getAllCategoryPosts')
        );
    }

    public function getCategoryPosts($category)
    {
        return $this->category->getCategoryPosts($category);
    }

    public function getAllCategoryPosts($category)
    {
        return $this->category->getAllCategoryPosts($category);
    }

    public function getSubCategories($category)
    {
        return $this->category->getSubCategories($category);
    }
}