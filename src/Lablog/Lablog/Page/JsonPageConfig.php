<?php

namespace Lablog\Lablog\Page;

class JsonPageConfig implements PageConfigGatewayInterface
{
    public function __construct()
    {

    }

    /**
     * Strip the config from the page and return the config and content
     * in an array.
     * @param  string $postContent
     * @param  string $wrap
     * @return array
     */
    public function strip($pageContent, $wrap)
    {
        $pattern = '/'.$wrap.'(.*?)'.$wrap.'/s';
        $match = preg_match($pattern, $pageContent, $matches);

        if ($match) {
            $page['config'] = $matches[1];
            $page['content'] = str_replace($matches[0], '', $pageContent);
            return $page;
        }

        return array('config' => '', 'content' => $pageContent);
    }

    /**
     * Decode the config and return it.
     * @param  string  $config
     * @param  boolean $array
     * @return mixed
     */
    public function decode($config, $array = false)
    {
        return json_decode($config, $array);
    }
}