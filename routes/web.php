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




Route::get('/register', function () {
    return abort('404');
});
Auth::routes();
Route::group(['middleware' => ['domain_setup','auth']], function () {
    Route::get('/home', 'HomeController@Index');
    Route::get('/', 'HomeController@Index');
   // Route::resource('users', 'UserController');
    //Route::resource('user-roles', 'UserRolesController');
    Route::get('/users', 'UserController@getIndex')->name('users');
    Route::get('/users/create', 'UserController@getCreate');
    Route::post('/users/store', 'UserController@postStore');
    Route::get('/users/edit/{id}', 'UserController@getEdit');
    Route::post('/users/update/{id}', 'UserController@postUpdate');
    Route::get('/users/destroy/{id}', 'UserController@getDestroy');


    Route::get('/user-roles', 'UserRolesController@Index')->name('user-roles');
    Route::get('/user-roles/create', 'UserRolesController@create');
    Route::post('/user-roles/store', 'UserRolesController@postStore');
    Route::get('/user-roles/edit/{id}', 'UserRolesController@getEdit');
    Route::post('/user-roles/update/{id}', 'UserRolesController@postUpdate');
    Route::get('/user-roles/destroy/{id}', 'UserRolesController@getDestroy');


    Route::get('/company', 'CompanyController@Index')->name('company');
    Route::get('/company/create', 'CompanyController@create');
    Route::post('/company/store', 'CompanyController@postStore');
    Route::get('/company/edit/{id}', 'CompanyController@getEdit');
    Route::post('/company/update/{id}', 'CompanyController@postUpdate');
    Route::get('/company/destroy/{id}', 'CompanyController@getDestroy');
});
