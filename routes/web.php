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
Route::group(['middleware' => ['domain_setup', 'auth']], function () {
    Route::get('/home', 'HomeController@getIndex');
    Route::get('/', 'HomeController@getIndex');
    Route::get('/set-up', 'HomeController@setup');
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

    Route::get('/stores', 'Location\StoresController@getIndex');
    Route::get('/stores/create', 'Location\StoresController@create');
    Route::post('/stores/store', 'Location\StoresController@postStore');
    Route::get('/stores/edit/{id}', 'Location\StoresController@getEdit');
    Route::post('/stores/update/{id}', 'Location\StoresController@postUpdate');
    Route::get('/stores/destroy/{id}', 'Location\StoresController@getDestroy');
    Route::get('/stores/update-status/{id}', 'Location\StoresController@getUpdateStatus');



    Route::get('/discount', 'DiscountController@Index')->name('discount');
    Route::post('/discount/save-discount', 'DiscountController@saveDiscount');
    Route::get('/discount/get-categories', 'DiscountController@getCategories');
    Route::get('/discount/get-items', 'DiscountController@getItems');
    Route::post('/discount/change-discount-status', 'DiscountController@changeDiscountStatus');
    Route::get('/discount/edit/{id}', 'DiscountController@getEdit');
    Route::post('/discount/save-edit-discount', 'DiscountController@saveEditDiscount');

    Route::get('/delivery-area', 'Location\DeliveryController@index')->name('delivery');
    Route::get('/delivery/edit-delivery/{id}', 'Location\DeliveryController@getEdit');
    Route::post('/delivery/save-delivery-store', 'Location\DeliveryController@saveDeliveryStore');
    Route::post('/delivery/change-delivery-status', 'Location\DeliveryController@changeDeliveryStatus');
    Route::post('/delivery/save-edit-delivery-store', 'Location\DeliveryController@saveEditDeliveryStore');
    Route::get('/delivery/delivery-area-gmap/{id}', 'Location\DeliveryController@deliveryAreaGmap');
    Route::post('/delivery/save-gmap-data', 'Location\DeliveryController@saveGmapData');
    Route::post('/delivery/delete-gmap-area', 'Location\DeliveryController@deleteGmapArea');
    Route::get('/delivery/delivery-area/{id}', 'Location\DeliveryController@deliveryArea');
    Route::post('/delivery/save-delivery-area', 'Location\DeliveryController@saveDeliveryArea');
    Route::post('/delivery/delete-area', 'Location\DeliveryController@deleteArea');

    Route::get('/order-type', 'Location\OrderTypeController@index');
    Route::post('/order-type/save', 'Location\OrderTypeController@save');
    Route::post('/order-type/change-status', 'Location\OrderTypeController@changeStatus');
    Route::get('/order-type/edit/{id}', 'Location\OrderTypeController@edit');
    Route::post('/order-type/save-edit', 'Location\OrderTypeController@saveEdit');
    
    Route::get('/brands', 'Location\BrandsController@getIndex');
    Route::get('/brands/create', 'Location\BrandsController@create');
    Route::post('/brands/store', 'Location\BrandsController@postStore');
    Route::get('/brands/edit/{id}', 'Location\BrandsController@getEdit');
    Route::post('/brands/update/{id}', 'Location\BrandsController@postUpdate');
    Route::get('/brands/destroy/{id}', 'Location\BrandsController@getDestroy');
    Route::get('/brands/update-status/{id}', 'Location\BrandsController@getUpdateStatus');
});
