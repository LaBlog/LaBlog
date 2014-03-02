<?php

namespace Lablog\Lablog\Post;

class FilePost implements PostInterface
{
    private $post;
    private $file;
    private $content;

    /**
     * Get a specified post.
     * @param  string $post
     * @return Post
     */
    public function getPost($post)
    {
        $this->path = $post;
        $file = app_path().'/lablog/'.$post.'.md';

        $file = str_replace('/', DIRECTORY_SEPARATOR, $file);

        $this->file = $file;

        if (file_exists($file)) {
            $post = file_get_contents($file);
            $this->post = $post;

            $post = new Post();
            $post->config = $this->getConfig();
            $post->title = $this->getTitle();
            $post->updated = $this->getDate();
            $post->content = $this->content;

            return $post;
        }

        return new Post();
    }

    /**
     * Get the config of a post file.
     * @return StdClass
     */
    private function getConfig()
    {
        $pattern = '/-POST CONFIG-(.*?)-POST CONFIG-/s';
        $match = preg_match($pattern, $this->post, $matches);

        if ($match) {
            $this->getContent($matches[0]);

            return json_decode($matches[1]);
        } else {
            $this->getContent();
        }
    }

    /**
     * Get the content from a post file.
     * @param  string $config The config in the post file to ignore.
     * @return void
     */
    private function getContent($config = '')
    {
        $content = str_replace($config, '', $this->post);

        $this->content = $content;
    }

    /**
     * Get the title of a post from the post name.
     * @return string
     */
    private function getTitle()
    {
        $pathItems = explode('/', $this->path);
        $title = end($pathItems);

        return $title;
    }

    /**
     * Get the modified date of the post.
     * @return string
     */
    private function getDate()
    {
        $date = filectime($this->file);

        return $date;
    }
}