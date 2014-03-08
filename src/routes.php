<?php

$prefix = Config::get('lablog::prefix');
$pages = Config::get('lablog::pages');

/**
 * Define LaBlog route patterns.
 */
Route::pattern('categories', '(.*)');
Route::pattern('pagename', '('.implode('|', $pages).')');
Route::pattern('pagenumber', '[0-9]+');
Route::pattern('page', 'page');

/**
 * Creation of the LaBlog route group with prefix.
 */
Route::group(['prefix' => $prefix], function() {
    Route::get('/', 'Lablog\Lablog\Controllers\PageController@showPage');
    Route::get('posts/{page?}/{pagenumber?}', 'Lablog\Lablog\Controllers\PostController@showPosts');
    Route::get('categories', 'Lablog\Lablog\Controllers\CategoryController@showCategories');
    Route::get('category/{categories?}/{page?}/{pagenumber}', 'Lablog\Lablog\Controllers\CategoryController@showCategory');
    Route::get('category/{categories?}', 'Lablog\Lablog\Controllers\CategoryController@showCategory');
    Route::get('{pagename}', 'Lablog\Lablog\Controllers\PageController@showPage');
    Route::get('post/{categories?}/{postname}', 'Lablog\Lablog\Controllers\PostController@showPost');
});