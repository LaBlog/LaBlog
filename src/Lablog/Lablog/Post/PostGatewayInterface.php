<?php

namespace Lablog\Lablog\Post;

interface PostGatewayInterface
{
    public function exists($path);
    public function get($path);
    public function modified($path);
    public function getAll($path);
}