<?php

namespace Lablog\Lablog\Post;

use Michelf\MarkdownExtra;

class Post
{
    private $title;
    private $config;
    private $updated;
    private $content;

    /**
     * Getter to get post values with config priority.
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->config->{$name})) {
            return $this->config->{$name};
        } elseif ($this->{$name}) {
            return $this->{$name};
        }
    }

    /**
     * Setter to set post values.
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    /**
     * Get the decoded markdown content as html.
     * @return string
     */
    public function content()
    {
        return MarkdownExtra::defaultTransform($this->content);
    }
}