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
    Route::get('/setup', 'HomeController@setup');
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
    Route::get('/brands/get_store_brand/{id}', 'Location\BrandsController@getStoreBrand');
    Route::post('/brands/update/{id}', 'Location\BrandsController@postUpdate');
    Route::get('/brands/destroy/{id}', 'Location\BrandsController@getDestroy');
    Route::get('/brands/update-status/{id}', 'Location\BrandsController@getUpdateStatus');

    Route::get('/surcharge', 'Location\SurchargeController@getIndex');
    Route::get('/surcharge/create', 'Location\SurchargeController@create');
    Route::post('/surcharge/store', 'Location\SurchargeController@postStore');
    Route::get('/surcharge/edit/{id}', 'Location\SurchargeController@getEdit');
    Route::post('/surcharge/update/{id}', 'Location\SurchargeController@postUpdate');
    Route::get('/surcharge/destroy/{id}', 'Location\SurchargeController@getDestroy');
    Route::get('/surcharge/update-status/{id}', 'Location\SurchargeController@getUpdateStatus');


    Route::get('/tax', 'Location\TaxController@getIndex');
    Route::get('/tax/create', 'Location\TaxController@create');
    Route::post('/tax/store', 'Location\TaxController@postStore');
    Route::get('/tax/edit/{id}', 'Location\TaxController@getEdit');
    Route::post('/tax/update/{id}', 'Location\TaxController@postUpdate');
    Route::get('/tax/destroy/{id}', 'Location\TaxController@getDestroy');
    Route::get('/tax/update-status/{id}', 'Location\TaxController@getUpdateStatus');



    Route::get('/payment', 'Location\PaymentsController@getIndex');
    Route::get('/payment/create', 'Location\PaymentsController@create');
    Route::post('/payment/store', 'Location\PaymentsController@postStore');
    Route::get('/payment/edit/{id}', 'Location\PaymentsController@getEdit');
    Route::post('/payment/update/{id}', 'Location\PaymentsController@postUpdate');
    Route::get('/payment/destroy/{id}', 'Location\PaymentsController@getDestroy');
    Route::get('/payment/update-status/{id}', 'Location\PaymentsController@getUpdateStatus');



    Route::get('/category', 'Menu\CategoryController@getIndex');
    Route::get('/category/create', 'Menu\CategoryController@create');
    Route::post('/category/store', 'Menu\CategoryController@postStore');
    Route::get('/category/edit/{id}', 'Menu\CategoryController@getEdit');
    Route::post('/category/update/{id}', 'Menu\CategoryController@postUpdate');
    Route::get('/category/destroy/{id}', 'Menu\CategoryController@getDestroy');
    Route::get('/category/update-status/{id}', 'Menu\CategoryController@getUpdateStatus');
    Route::get('/category/get-sub-category/{id}', 'Menu\CategoryController@getSubCategories');

    Route::get('/modifier-choice', 'Menu\ModifierChoiceController@getIndex');
    Route::get('/modifier-choice/create', 'Menu\ModifierChoiceController@create');
    Route::post('/modifier-choice/store', 'Menu\ModifierChoiceController@postStore');
    Route::get('/modifier-choice/edit/{id}', 'Menu\ModifierChoiceController@getEdit');
    Route::post('/modifier-choice/update/{id}', 'Menu\ModifierChoiceController@postUpdate');
    Route::get('/modifier-choice/destroy/{id}', 'Menu\ModifierChoiceController@getDestroy');
    Route::get('/modifier-choice/update-status/{id}', 'Menu\ModifierChoiceController@getUpdateStatus');

    Route::get('/modifier', 'Menu\ModifierController@getIndex');
    Route::get('/modifier/create', 'Menu\ModifierController@create');
    Route::post('/modifier/store', 'Menu\ModifierController@postStore');
    Route::get('/modifier/edit/{id}', 'Menu\ModifierController@getEdit');
    Route::post('/modifier/update/{id}', 'Menu\ModifierController@postUpdate');
    Route::get('/modifier/destroy/{id}', 'Menu\ModifierController@getDestroy');
    Route::get('/modifier/update-status/{id}', 'Menu\ModifierController@getUpdateStatus');

    Route::get('/modifier-group', 'Menu\ModifierGroupController@getIndex');
    Route::get('/modifier-group/create', 'Menu\ModifierGroupController@create');
    Route::post('/modifier-group/store', 'Menu\ModifierGroupController@postStore');
    Route::get('/modifier-group/edit/{id}', 'Menu\ModifierGroupController@getEdit');
    Route::post('/modifier-group/update/{id}', 'Menu\ModifierGroupController@postUpdate');
    Route::get('/modifier-group/destroy/{id}', 'Menu\ModifierGroupController@getDestroy');
    Route::get('/modifier-group/update-status/{id}', 'Menu\ModifierGroupController@getUpdateStatus');
    Route::get('/modifier-group/get-group-modfiers/{id}', 'Menu\ModifierGroupController@getGroupModifiers');

    Route::get('/item', 'Menu\MenuController@getIndex');
    Route::get('/item/create', 'Menu\MenuController@create');
    Route::post('/item/store', 'Menu\MenuController@postStore');
    Route::get('/item/edit/{id}', 'Menu\MenuController@getEdit');
    Route::post('/item/update/{id}', 'Menu\MenuController@postUpdate');
    Route::get('/item/destroy/{id}', 'Menu\MenuController@getDestroy');
    Route::get('/item/update-status/{id}', 'Menu\MenuController@getUpdateStatus');
    Route::get('/item/sort/{id}', 'Menu\MenuController@getSortOrder');
    Route::post('/item/save-sort-order/{id}', 'Menu\MenuController@postSortOrder');


    Route::get('/pos/itemlist', 'Pos\PosController@getIndex');

    Route::get('/pos', 'Pos\CustomerController@getIndex');
    Route::post('/customer', 'Pos\CustomerController@getCustomer');
    Route::post('/save-customer', 'Pos\CustomerController@saveCustomer');
    Route::post('/order', 'Pos\CustomerController@order');
    Route::get('/getData', 'Pos\PosController@getData');
});
 
