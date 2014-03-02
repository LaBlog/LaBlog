<?php

return array(

    /**
     * Register the prefix for the LaBlog system.
     * Default: '/' (Eg. domain.com will go to your blog home.)
     * Example: '/blog' (Eg. domain.com/blog will go to your blog home.)
     */
    'prefix' => 'blog',

    /**
     * Set the module to use Lablog as.
     * Options: file, database
     */
    'mode' => 'file',

    /**
     * Add any extra blog pages you wish to have here.
     * Example: about, contact, terms_and_conditions
     */
    'pages' => array(
        'about',
        'contact'
    )

);