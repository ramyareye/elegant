<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function($api){

    $api->group(
        [
            'middleware' => ['throttle:60,1', 'bindings'], 
            'namespace' => 'App\Http\Controllers'
        ], function($api) {

        $api->get('ping', 'Api\PingController@index');

        $api->group(['middleware' => ['auth:api'], ], function ($api) {

            $api->group(['prefix' => 'admins'], function ($api) {
                $api->get('/', 'Api\Users\AdminsController@index');
                $api->post('/', 'Api\Users\AdminsController@store');
                $api->get('/{uuid}', 'Api\Users\AdminsController@show');
                $api->put('/{uuid}', 'Api\Users\AdminsController@update');
                $api->patch('/{uuid}', 'Api\Users\AdminsController@update');
                $api->delete('/{uuid}', 'Api\Users\AdminsController@destroy');
            });

            $api->group(['prefix' => 'users'], function ($api) {
                $api->get('/', 'Api\Users\UsersController@index');                
                $api->post('/', 'Api\Users\UsersController@store');
                $api->get('/{uuid}', 'Api\Users\UsersController@show');
                $api->put('/{uuid}', 'Api\Users\UsersController@update');
                $api->patch('/{uuid}', 'Api\Users\UsersController@update');
                $api->delete('/{uuid}', 'Api\Users\UsersController@destroy');

                $api->post('search', 'Api\Users\UsersController@search');
            });

            $api->group(['prefix' => 'roles'], function ($api) {
                $api->get('/', 'Api\Users\RolesController@index');
                $api->post('/', 'Api\Users\RolesController@store');
                $api->get('/{uuid}', 'Api\Users\RolesController@show');
                $api->put('/{uuid}', 'Api\Users\RolesController@update');
                $api->patch('/{uuid}', 'Api\Users\RolesController@update');
                $api->delete('/{uuid}', 'Api\Users\RolesController@destroy');
            });

            $api->get('permissions', 'Api\Users\PermissionsController@index');

            $api->group(['prefix' => 'me'], function($api) {
                $api->get('/', 'Api\Users\ProfileController@index');
                $api->put('/', 'Api\Users\ProfileController@update');
                $api->patch('/', 'Api\Users\ProfileController@update');
                $api->put('/password', 'Api\Users\ProfileController@updatePassword');
            });

            $api->post('/logout', 'Api\AuthController@logout');


            /*********************/

            $api->group(['prefix' => 'categories'], function ($api) {
                $api->get('/', 'Api\CategoriesController@index');
                $api->post('/', 'Api\CategoriesController@store');
                $api->get('{uuid}', 'Api\CategoriesController@show');
                $api->put('{uuid}', 'Api\CategoriesController@update');
                $api->patch('{uuid}', 'Api\CategoriesController@update');
                $api->delete('{uuid}', 'Api\CategoriesController@destroy');
                $api->post('search', 'Api\CategoriesController@search');
                $api->post('up/{id}', 'Api\CategoriesController@up');
                $api->post('down/{id}', 'Api\CategoriesController@down');

                $api->post('/{id}/upload/images', 'Api\CategoriesController@uploadFile');
                $api->post('/{id}/upload/images/{image_id}', 'Api\CategoriesController@deleteFile');

                $api->post('/{id}/upload/cover', 'Api\CategoriesController@uploadCover');
                $api->post('/{id}/upload/cover/{cover_id}', 'Api\CategoriesController@deleteCover');

                $api->post('/{id}/upload/image', 'Api\CategoriesController@uploadImage');
                $api->post('/{id}/upload/image/{cover_id}', 'Api\CategoriesController@deleteImage');
            });

            $api->group(['prefix' => 'tags'], function ($api) {
                $api->post('search', 'Api\TagsController@search');
            });

            $api->group(['prefix' => 'posts'], function ($api) {
                $api->get('/', 'Api\PostsController@index');
                $api->post('/', 'Api\PostsController@store');
                $api->get('/{uuid}', 'Api\PostsController@show');
                $api->put('/{uuid}', 'Api\PostsController@update');
                $api->patch('/{uuid}', 'Api\PostsController@update');
                $api->delete('/{uuid}', 'Api\PostsController@destroy');

                $api->post('/{id}/upload/images', 'Api\PostsController@uploadFile');
                $api->post('/{id}/upload/images/{image_id}', 'Api\PostsController@deleteFile');
            });

            $api->group(['prefix' => 'pages'], function ($api) {
                $api->get('/parents', 'Api\PagesController@parents');
                $api->get('/', 'Api\PagesController@index');                
                $api->post('/', 'Api\PagesController@store');
                $api->get('/{uuid}', 'Api\PagesController@show');
                $api->put('/{uuid}', 'Api\PagesController@update');
                $api->patch('/{uuid}', 'Api\PagesController@update');
                $api->delete('/{uuid}', 'Api\PagesController@destroy');

                $api->post('/{id}/upload/images', 'Api\PagesController@uploadFile');
                $api->post('/{id}/upload/images/{image_id}', 'Api\PagesController@deleteFile');

                $api->post('/{id}/upload/cover', 'Api\PagesController@uploadCover');
                $api->post('/{id}/upload/cover/{cover_id}', 'Api\PagesController@deleteCover');

                $api->post('/{id}/upload/image', 'Api\PagesController@uploadImage');
                $api->post('/{id}/upload/image/{cover_id}', 'Api\PagesController@deleteImage');

                $api->post('search', 'Api\PagesController@search');
            });

            $api->group(['prefix' => 'slides'], function ($api) {
                $api->get('/', 'Api\SlidesController@index');                
                $api->post('/', 'Api\SlidesController@store');
                $api->get('/{uuid}', 'Api\SlidesController@show');
                $api->put('/{uuid}', 'Api\SlidesController@update');
                $api->patch('/{uuid}', 'Api\SlidesController@update');
                $api->delete('/{uuid}', 'Api\SlidesController@destroy');

                $api->post('/{id}/upload/image', 'Api\SlidesController@uploadImage');
                $api->post('/{id}/upload/image/{image_id}', 'Api\SlidesController@deleteImage');

                $api->post('/{id}/upload/mobile', 'Api\SlidesController@uploadMobile');
                $api->post('/{id}/upload/mobile/{mobile_id}', 'Api\SlidesController@deleteMobile');
            });

        });

        $api->post('/register', 'Api\AuthController@register');
        $api->post('/login', 'Api\AuthController@login');
    });

});



