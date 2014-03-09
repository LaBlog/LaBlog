<?php

namespace Lablog\Lablog\Category;

interface CategoryGatewayInterface
{
    public function exists($category);
    public function getSubCategories($category);
    public function getCategory($category);
    public function getParentCategory($category);
}