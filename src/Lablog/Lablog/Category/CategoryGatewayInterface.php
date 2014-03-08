<?php

namespace Lablog\Lablog\Category;

interface CategoryGatewayInterface
{
    public function exists($path);
    public function getSubCategories($category);
    public function getCategory($category);
    public function getCategoryPosts($category);
    public function getAllCategoryPosts($category);
}