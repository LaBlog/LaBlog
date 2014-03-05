<?php

namespace Lablog\Lablog\Page;

interface PageGatewayInterface
{
    public function exists($path);
    public function get($path);
    public function modified($path);
}