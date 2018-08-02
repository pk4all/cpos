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
    Route::get('/home', 'HomeController@getIndex');
    Route::get('/', 'HomeController@getIndex');
   // Route::resource('users', 'UserController');
    //Route::resource('user-roles', 'UserRolesController');
    Route::get('/users', 'UserController@getIndex')->name('users');
    Route::get('/users/create', 'UserController@getCreate');
    Route::post('/users/store', 'UserController@postStore');
    Route::get('/users/edit/{id}', 'UserController@getEdit');
    Route::post('/users/update/{id}', 'UserController@postUpdate');
    Route::get('/users/destroy/{id}', 'UserController@getDestroy');


    Route::get('/user-roles', 'UserRolesController@getIndex')->name('user-roles');
    Route::get('/user-roles/create', 'UserRolesController@create');
    Route::post('/user-roles/store', 'UserRolesController@postStore');
    Route::get('/user-roles/edit/{id}', 'UserRolesController@getEdit');
    Route::post('/user-roles/update/{id}', 'UserRolesController@postUpdate');
    Route::get('/user-roles/destroy/{id}', 'UserRolesController@getDestroy');


    Route::get('/company', 'CompanyController@getIndex')->name('company');
    Route::get('/company/create', 'CompanyController@create');
    Route::post('/company/store', 'CompanyController@postStore');
    Route::get('/company/edit/{id}', 'CompanyController@getEdit');
    Route::post('/company/update/{id}', 'CompanyController@postUpdate');
    Route::get('/company/destroy/{id}', 'CompanyController@getDestroy');
    
    
     Route::get('/stores', 'location\StoresController@getIndex');
    Route::get('/stores/create', 'location\StoresController@create');
    Route::post('/stores/store', 'location\StoresController@postStore');
    Route::get('/stores/edit/{id}', 'location\StoresController@getEdit');
    Route::post('/stores/update/{id}', 'location\StoresController@postUpdate');
    Route::get('/stores/destroy/{id}', 'location\StoresController@getDestroy');
    Route::get('/stores/update-status/{id}', 'location\StoresController@getUpdateStatus');   
    
});
