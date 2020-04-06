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

Route::get('/', 'HomeController@index', 301);

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    //page
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/assign', 'AssignController@index')->name('useradmin.assign');
    Route::get('/group', 'GroupController@group')->name('useradmin.group');
    Route::get('/user', 'UserController@user')->name('useradmin.user');
    Route::get('/sales', 'SalesController@sales')->name('masterdata.sales');
    Route::get('/dealer', 'DealerController@dealer')->name('masterdata.dealer');
    Route::get('/customer', 'CustomerController@customer')->name('masterdata.customer');

    //feature
    Route::get('/test', 'UserController@getMaxID');
    Route::get('get-detailUser', 'UserController@getDetailUser');
    Route::get('username-unique', 'UserController@uniqueUsername');
    Route::get('username-get', 'UserController@getUsername');
    Route::get('get-iduser', 'UserController@getIdUser');
    Route::get('username-registrasi', 'UserController@registrasiUser');
    Route::get('username-update', 'UserController@updateUser');
    Route::get('get-dataRegistrasi/{id}', 'UserController@dataRegistrasi')->name('data-registrasi');
    Route::get('/user/{id}/edit', 'UserController@userEdit')->name('useradmin.user-edit');
    Route::get('/user/{id}/reset/password', 'UserController@userResetPassword')->name('useradmin.user-reset-password');
    Route::get('/user/{id}/reset/pin', 'UserController@userResetPIN')->name('useradmin.user-reset-pin');
    Route::get('get-dataClient/{id}', 'UserController@dataClient')->name('data-client');
    Route::get('get-dataAOList/{id}', 'AssignController@getListAO');

    Route::get('group-registrasi', 'GroupController@registrasiGroup');
    Route::get('group-get', 'GroupController@getGroup');
    Route::get('get-idgroup', 'GroupController@getIdGroup');
    Route::get('get-dataGroup/{id}', 'GroupController@dataGroup')->name('data-group');
    Route::get('/group/{id}', 'GroupController@groupEdit')->name('group-edit');
    Route::get('group-update', 'GroupController@groupEdit');
    Route::get('group-update/submit', 'GroupController@updateGroup');
    Route::get('getGroupUser/{id}','AssignController@getGroupUser');

    Route::get('addNewUserGroup', 'UserController@addUserGroup');
    Route::get('delUserGroup', 'UserController@deleteUserGroup');

    Route::get('getDataDealer','DealerController@getDealer');
    Route::get('getDealerId','DealerController@getIdDealer');
    Route::get('dealer-registrasi', 'DealerController@registrasiDealer');
    Route::get('dealer-update', 'DealerController@dealerEdit');
    Route::get('dealer-update/submit', 'DealerController@updateDealer');
    Route::get('dealerGetSales', 'DealerController@dealerGetSales');
    Route::get('dealerAssign/add/', 'DealerController@dealerAssignAdd');
    Route::get('dealerAssign/remove/', 'DealerController@dealerAssignRemove');


    Route::get('getDataSales','SalesController@getSales');
    Route::get('sales-registrasi', 'SalesController@registrasiSales');
    Route::get('sales-update', 'SalesController@salesEdit');
    Route::get('sales-update/submit', 'SalesController@updateSales');

    Route::get('getDataCustomer','CustomerController@getCustomer');
    Route::get('getDataCustomerDetail','CustomerController@getCustomerDetail');

});
