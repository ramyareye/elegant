<?php

Auth::routes();

/******************* Home *******************/

Route::name('home')->get('/',
  'HomeController@home'
);

Route::get('/el-admin', 'BackendController@index');
