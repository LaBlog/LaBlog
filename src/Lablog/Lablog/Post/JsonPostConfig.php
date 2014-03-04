<?php

namespace Lablog\Lablog\Post;

class JsonPostConfig implements PostConfigGatewayInterface
{
    public function __construct()
    {

    }

    /**
     * Strip the config from the post and return the config and content
     * in an array.
     * @param  string $postContent
     * @param  string $wrap
     * @return array
     */
    public function strip($postContent, $wrap)
    {
        $pattern = '/'.$wrap.'(.*?)'.$wrap.'/s';
        $match = preg_match($pattern, $postContent, $matches);

        if ($match) {
            $post['config'] = $matches[1];
            $post['content'] = str_replace($matches[0], '', $postContent);
            return $post;
        }

        return array();
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