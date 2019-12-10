<?php

Route::redirect('/', '/login');

Route::redirect('/home', '/admin');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');

    Route::resource('permissions', 'PermissionsController');

    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

    Route::resource('roles', 'RolesController');

    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');

    Route::resource('users', 'UsersController');

    Route::delete('products/destroy', 'ProductsController@massDestroy')->name('products.massDestroy');

    Route::resource('products', 'ProductsController');
    Route::resource('usermanage', 'administrator\UsermanageController');

    Route::resource('Projectmanage', 'administrator\ProjectmanageController');
    Route::resource('productsubgroup', 'products\ProductsubgroupController');
    Route::resource('unitmanage', 'products\UnitmanageController');
    Route::resource('productmanage', 'products\ProductmanageController');
    Route::resource('localpurchase', 'purchase\LocalpurchaseController');
    Route::post('localpurchase/search', 'purchase\LocalpurchaseController@search')->name('search');
    
    Route::post('/auto/fetch', 'purchase\LocalpurchaseController@fetch')->name('auto.fetch');
    Route::post('/auto/get', 'purchase\LocalpurchaseController@stocks')->name('auto.get');
    Route::post('/insert', 'purchase\LocalpurchaseController@create')->name('create');











});
