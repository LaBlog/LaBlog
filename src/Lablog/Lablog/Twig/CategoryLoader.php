<?php

namespace Lablog\Lablog\Twig;

use Twig_Environment;
use Twig_Function_Function;
use Twig_Function_Method;
use Twig_Filter_Method;
use Twig_Extension;

class CategoryLoader extends Twig_Extension
{
    public function __construct()
    {
        $this->category = \App::make('Lablog\Lablog\Category\CategoryGatewayInterface');
    }

    public function getName()
    {
        return 'CategoryLoader';
    }

    public function getFunctions()
    {
        return array(
            'getCategory' => new Twig_Function_Method($this, 'getCategory'),
            'getSubCategories' => new Twig_Function_Method($this, 'getSubCategories'),
        );
    }

    public function getCategory($category)
    {
        return $this->category->getCategory($category);
    }

    public function getSubCategories($category)
    {
        return $this->category->getSubCategories($category);
    }
}