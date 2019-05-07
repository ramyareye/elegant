<?php

Auth::routes();

/******************* Home *******************/

Route::name('home')->get('/',
  'Front\HomeController@home'
);

Route::get('sitemap.xml', 'Front\SitemapController@index');
Route::get('sitemap.xml/categories', 'Front\SitemapController@categories');

Route::get('/el-admin', 'BackendController@index');
