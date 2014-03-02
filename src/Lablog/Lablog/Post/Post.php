<?php

namespace Lablog\Lablog\Post;

use Michelf\MarkdownExtra;

class Post
{
    private $title;
    private $config;
    private $updated;
    private $content;

    public function __get($name)
    {
        if (isset($this->config->{$name})) {
            return $this->config->{$name};
        } elseif ($this->{$name}) {
            return $this->{$name};
        }
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function content()
    {
        return MarkdownExtra::defaultTransform($this->content);
    }
}