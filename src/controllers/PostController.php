<?php

namespace Lablog\Lablog\Controllers;

use Lablog\Lablog\Post\PostGatewayInterface;
use Lablog\Lablog\Post\PostConfigGatewayInterface;
use Lablog\Lablog\Post\Post;
use Stringy\StringyStatic as Stringy;
use Michelf\MarkdownExtra as Markdown;

class PostController extends \BaseController
{
    public function __construct(PostGatewayInterface $post, PostConfigGatewayInterface $postConfig)
    {
        $this->post = $post;
        $this->postConfig = $postConfig;
    }

    /**
     * Show all of the posts.
     * @return \View
     */
    public function showPosts()
    {
        echo 'All posts.';
    }

    /**
     * Show a single post.
     * @param string $postName The name of the post to retrieve.
     * @return \View
     */
    public function showPost($category, $postName)
    {
        $ds = DIRECTORY_SEPARATOR;
        $postPath = str_replace('/', $ds, $category.'/'.$postName);

        $fullPostPath = app_path().$ds.'lablog'.$ds.$postPath.'.md';

        if ($this->post->exists($fullPostPath)) {
            $postContent = $this->post->get($fullPostPath);

            $configWrap = \Config::get('lablog::post.configWrap') ?: '{POSTCONFIG}';

            $postContent = $this->postConfig->strip($postContent, $configWrap);

            $config = $this->postConfig->decode($postContent['config']);

            if (isset($config->title)) {
                $name = $config->title;
            } else {
                $name = $postName;
            }

            if (isset($config->content)) {
                $content = $config->content;
            } else {
                $content = $postContent['content'];
            }

            if (isset($config->modified)) {
                $modified = $config->modified;
            } else {
                $modified = $this->post->modified($fullPostPath);
            }

            $path = $fullPostPath;

            $post = new Post;
            $post->name = $name;
            $post->modified = $modified;
            $post->content = Markdown::defaultTransform($content);
            $post->path = $path;

            $template = \Config::get('lablog::theme');
            $extra = \Config::get('lablog::extra.post');

            $results = array();

            foreach ($config->call as $call) {
                $class = $call->call;
                $params = $call->params;

                $item = explode('.', $params[0]);
                unset($params[0]);

                $paramaters[] = ${$item[0]}->{$item[1]};

                $params = array_merge($paramaters, $params);

                $result = call_user_func_array($class, $params);

                $results[$call->name] = $result;
            }

            return \View::make('lablog::themes.'.$template.'.post', array(
                'post' => $post,
                'extra' => $extra,
                'string' => function() {
                    return function($name) {
                        echo ucfirst($name);
                    };
                },
                'results' => $results
            ));

        } else {

        }
    }
}