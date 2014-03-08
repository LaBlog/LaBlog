<?php

return array(
    /**
     * Register the processor binding.
     * Default: 'Lablog\Lablog\Processor\MarkdownProcessor'
     */
    'Lablog\Lablog\Processor\ProcessorInterface' => 'Lablog\Lablog\Processor\MarkdownProcessor',

    /**
     * Register the page type binding.
     * Default: 'Lablog\Lablog\Page\FilePage'
     */
    'Lablog\Lablog\Page\PageGatewayInterface' => 'Lablog\Lablog\Page\FilePage',

    /**
     * Register the page config type binding.
     * Default: 'Lablog\Lablog\Page\JsonPageConfig'
     */
    'Lablog\Lablog\Page\PageConfigGatewayInterface' => 'Lablog\Lablog\Page\JsonPageConfig',

    /**
     * Register the post type binding.
     * Default: 'Lablog\Lablog\Post\FilePost'
     */
    'Lablog\Lablog\Post\PostGatewayInterface' => 'Lablog\Lablog\Post\FilePost',

    /**
     * Register the post config type binding.
     * Default: 'Lablog\Lablog\Post\JsonPostConfig'
     */
    'Lablog\Lablog\Post\PostConfigGatewayInterface' => 'Lablog\Lablog\Post\JsonPostConfig',

    /**
     * Register the category type binding.
     * Default: 'Lablog\Lablog\Category\FileCategory'
     */
    'Lablog\Lablog\Category\CategoryGatewayInterface' => 'Lablog\Lablog\Category\FileCategory',
);