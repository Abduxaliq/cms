<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'HomeGetController@get_home');
Route::get('/category/{slug}', 'HomeGetController@get_category_list');
Route::get('/posts/{slug}', 'HomeGetController@get_posts_details');
Route::get('/allnews', 'HomeGetController@get_all_category_list');
Route::get('/tags/{slug}', 'HomeGetController@get_home');
Route::get('/tags', 'HomeGetController@get_home');
Route::get('/calendar/{date}', 'HomeGetController@get_calendar');
Route::get('/counters', 'HomeGetController@get_counters');
Route::get('/banner', 'HomeGetController@get_banner');
Route::get('/yaz.html', 'HomeGetController@get_banner');
Route::get('/yaz.htm', 'HomeGetController@get_banner');
Route::get('/sitemap.xml', 'HomeController@get_sitemap');
Route::get('/voting', 'HomeGetController@get_voting');

Route::match(['get', 'post'],'/send/voting', 'HomePostController@post_voting');

Route::get('/web/{status}', 'HomeGetController@get_home');
Route::match(['get', 'post'],'/search','HomePostController@post_search');

Route::get('/admin/signin', 'AdminGetController@get_login')->name('admin.signin');
Route::post('/admin/signin', 'AdminPostController@post_login');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    // Route::get('/new/slug/add', 'AdminGetController@get_new_slug');
    Route::get('/', 'AdminGetController@get_home');
    Route::match(['get', 'post'], '/logout', 'AdminGetController@get_logout')->name('logout');
    Route::get('/settings', 'AdminGetController@get_settings');
    Route::post('/settings', 'AdminPostController@post_settings');

    Route::group(['prefix' => 'menus'], function () {
        Route::get('/', 'AdminGetController@get_menus');
        Route::post('/', 'AdminPostController@post_menus_delete');
        Route::get('/add', 'AdminGetController@get_add_menu');
        Route::post('/add', 'AdminPostController@post_add_menu');
        Route::get('/edit/{slug}', 'AdminGetController@get_edit_menu');
        Route::post('/edit/{slug}', 'AdminPostController@post_edit_menu');
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'AdminGetController@get_category');
        Route::post('/', 'AdminPostController@post_category_delete');
        Route::get('/add', 'AdminGetController@get_add_category');
        Route::post('/add', 'AdminPostController@post_add_category');
        Route::get('/edit/{slug}', 'AdminGetController@get_edit_category');
        Route::post('/edit/{slug}', 'AdminPostController@post_edit_category');
    });

    Route::group(['prefix' => 'position'], function () {
        Route::get('/', 'AdminGetController@get_position');
        Route::post('/', 'AdminPostController@post_position_delete');
        Route::get('/add', 'AdminGetController@get_add_position');
        Route::post('/add', 'AdminPostController@post_add_position');
        Route::get('/edit/{slug}', 'AdminGetController@get_edit_position');
        Route::post('/edit/{slug}', 'AdminPostController@post_edit_position');
    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('/add', 'AdminGetController@get_add_posts');
        Route::post('/add', 'AdminPostController@post_add_posts');
        Route::get('/edit/{slug}', 'AdminGetController@get_edit_posts');
        Route::post('/edit/{slug}', 'AdminPostController@post_edit_posts');
        Route::get('/{date}', 'AdminGetController@get_posts_date');
        Route::get('/', 'AdminGetController@get_posts');
        Route::post('/', 'AdminPostController@post_posts_delete');
    });

    Route::group(['prefix' => 'page'], function () {
        Route::get('/', 'AdminGetController@get_page');
        Route::post('/', 'AdminPostController@post_page_delete');
        Route::get('/add', 'AdminGetController@get_add_page');
        Route::post('/add', 'AdminPostController@post_add_page');
        Route::get('/edit/{slug}', 'AdminGetController@get_edit_page');
        Route::post('/edit/{slug}', 'AdminPostController@post_edit_page');
    });

    Route::group(['prefix' => 'ads'], function () {
        Route::get('/', 'AdminGetController@get_ads');
        Route::post('/', 'AdminPostController@post_ads_delete');
        Route::get('/add', 'AdminGetController@get_add_ads');
        Route::post('/add', 'AdminPostController@post_add_ads');
        Route::get('/edit/{id}', 'AdminGetController@get_edit_ads');
        Route::post('/edit/{id}', 'AdminPostController@post_edit_ads');
    });

    Route::group(['prefix' => 'voting'], function () {
        Route::get('/', 'AdminGetController@get_voting');
        Route::post('/', 'AdminPostController@post_voting_delete');
        Route::get('/add', 'AdminGetController@get_add_voting');
        Route::post('/add', 'AdminPostController@post_add_voting');
        Route::get('/edit/{id}', 'AdminGetController@get_edit_voting');
        Route::post('/edit/{id}', 'AdminPostController@post_edit_voting');
    });

    Route::group(['prefix' => 'document'], function () {
        Route::get('/', 'AdminGetController@get_document');
        Route::post('/', 'AdminPostController@post_document_delete');
        Route::get('/add', 'AdminGetController@get_add_document');
        Route::post('/add', 'AdminPostController@post_add_document');
        Route::get('/edit/{id}', 'AdminGetController@get_edit_document');
        Route::post('/edit/{id}', 'AdminPostController@post_edit_document');
    });

});
