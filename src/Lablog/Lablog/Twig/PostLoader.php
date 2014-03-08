<?php

namespace Lablog\Lablog\Twig;

use Twig_Environment;
use Twig_Function_Function;
use Twig_Function_Method;
use Twig_Filter_Method;
use Twig_Extension;
use Illuminate\Filesystem\Filesystem;

class PostLoader extends Twig_Extension
{
    public function __construct()
    {
        $this->post = \App::make('Lablog\Lablog\Post\PostGatewayInterface');
    }

    public function getName()
    {
        return 'PostLoader';
    }

    public function getFunctions()
    {
        return array(
            'getAllPosts' => new Twig_Function_Method($this, 'getAllPosts'),
            'getPost' => new Twig_Function_Method($this, 'getPost'),
        );
    }

    public function getAllPosts()
    {
        return $this->post->findAll();
    }

    public function getPost($category, $post)
    {
        return $this->post->getPost($category, $post);
    }
}