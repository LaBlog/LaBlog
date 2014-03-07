<?php

namespace Lablog\Lablog\Twig;

use Twig_Environment;
use Twig_Function_Function;
use Twig_Filter_Method;
use Twig_Extension;

class PaginationLoader extends Twig_Extension
{
    public function getName()
    {
        return 'PaginationLoader';
    }

    public function getFilters()
    {
        return array(
            'paginate' => new Twig_Filter_Method($this, 'paginate')
        );
    }

    public function paginate(array $content, $page, $perPage)
    {
        $offset = $perPage * $page - $perPage;
        $length = $perPage;

        $result = array_slice($content, $offset, $length);

        return $result;
    }
}