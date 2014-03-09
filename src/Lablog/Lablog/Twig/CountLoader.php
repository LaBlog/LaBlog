<?php

namespace Lablog\Lablog\Twig;

use Twig_Environment;
use Twig_Function_Function;
use Twig_Function_Method;
use Twig_Filter_Method;
use Twig_Extension;

class CountLoader extends Twig_Extension
{
    public function getName()
    {
        return 'CountLoader';
    }

    public function getFilters()
    {
        return array(
            'count' => new Twig_Filter_Method($this, 'count')
        );
    }

    public function count(array $array)
    {
        return count($array);
    }
}