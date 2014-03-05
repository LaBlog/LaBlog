<?php

namespace Lablog\Lablog\Page;

interface PageConfigGatewayInterface
{
    public function strip($pageContent, $wrap);
    public function decode($pageContent, $array = false);
}