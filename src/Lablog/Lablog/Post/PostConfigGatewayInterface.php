<?php

namespace Lablog\Lablog\Post;

interface PostConfigGatewayInterface
{
    public function strip($postContent, $wrap);
    public function decode($postContent, $array = false);
}