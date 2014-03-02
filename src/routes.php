<?php

$prefix = Config::get('lablog::prefix');
$pages = Config::get('lablog::pages');

/**
 * Define LaBlog route patterns.
 */
Route::pattern('categories', '(.*)');
Route::pattern('pagename', '('.implode('|', $pages).')');

/**
 * Creation of the LaBlog route group with prefix.
 */
Route::group(['prefix' => $prefix], function() {
    Route::get('/', 'Lablog\Lablog\Controllers\BlogController@showHome');
    Route::get('posts', 'Lablog\Lablog\Controllers\PostController@showPosts');
    Route::get('category/{categories?}', 'Lablog\Lablog\Controllers\CategoryController@showCategory');
    Route::get('{pagename}', 'Lablog\Lablog\Controllers\PageController@showPage');
    Route::get('{categories?}/{postname}', 'Lablog\Lablog\Controllers\PostController@showPost');
});