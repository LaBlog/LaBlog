<?php

namespace Lablog\Lablog\Post;

interface PostGatewayInterface
{
    public function exists($category, $post);
    public function modified($path);
    public function getAll($path);
}