<?php

return array(

    /**
     * Register the prefix for the LaBlog system.
     * Default: '/' (Eg. domain.com will go to your blog home.)
     * Example: '/blog/' (Eg. domain.com/blog will go to your blog home.)
     *
     * Please remember to keep a slash at the end of the prefix!
     */
    'prefix' => '/',

    /**
     * Add any extra blog pages you wish to have here.
     * Example: about, contact, terms_and_conditions
     */
    'pages' => array(
        'about',
        'contact'
    ),

    /**
     * Select a theme for the blog.
     */
    'theme' => 'lablog::lablog.default',

);