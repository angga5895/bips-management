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
    Route::get('/user', 'UserController@user')->name('useradmin.user');
    Route::get('/sales', 'SalesController@sales')->name('masterdata.sales');
    Route::get('/dealer', 'DealerController@dealer')->name('masterdata.dealer');
    Route::get('/customer', 'CustomerController@customer')->name('masterdata.customer');
    Route::get('/assign', 'AssignController@index')->name('masterdata.assign');
    Route::get('/group', 'GroupController@group')->name('masterdata.group');
    // page new
    Route::get('/useradmin', 'PrivilegeController@useradmin')->name('adminprivilege.upadmin');
    Route::get('/roleadmin', 'PrivilegeController@roleadmin')->name('adminprivilege.uradmin');
    //page risk management
    Route::get('/tradelimit', 'RiskManagementController@tradelimit')->name('riskmanagement.tradelimit');
    Route::get('/statistics/tradesummary', 'StatisticController@tradesummary')->name('statistic.tradesummary');
    Route::get('/statistics/customersummary', 'StatisticController@customersummary')->name('statistic.customersummary');

    Route::get('get-becust', 'RiskManagementController@getBECust');
    Route::get('get-becuststock/{id}', 'RiskManagementController@getBECustStock');
    //feature
    Route::get('charttradesummary-get', 'StatisticController@chartTradeSummary');
    Route::get('chartcustomersummary-get', 'StatisticController@chartCustomerSummary');

    Route::get('nameadmin-check', 'PrivilegeController@checkNameAdmin');
    Route::get('get-dataRole/{id}', 'PrivilegeController@dataRole')->name('data-role');
    Route::get('roleadmin-update', 'PrivilegeController@roleadminEdit');
    Route::get('rolenameadmin-registrasi', 'PrivilegeController@registrasiRoleAdmin');
    Route::get('roleadmin-update/submit', 'PrivilegeController@updateRoleadmin');
    Route::get('rolenameadmin-get', 'PrivilegeController@getRolenameAdmin');
    Route::get('rolenameadmin-checkclapp', 'PrivilegeController@checkclApp');
    Route::get('roleadmin-privilege/submit', 'PrivilegeController@updateRoleadminPrivilege');

    Route::get('useradmin-delete/submit', 'PrivilegeController@deleteUseradmin');
    Route::get('useradmin-update', 'PrivilegeController@useradminEdit');
    Route::get('useradmin-update/submit', 'PrivilegeController@updateUseradmin');
    Route::get('usernameadmin-registrasi', 'PrivilegeController@registrasiUserAdmin');
    Route::get('usernameadmin-get', 'PrivilegeController@getUsernameAdmin');
    Route::get('usernameadmin-check', 'PrivilegeController@checkUsernameAdmin');
    Route::get('get-dataAdmin/{id}', 'PrivilegeController@dataAdmin')->name('data-admin');

    Route::get('/test', 'UserController@getMaxID');
    Route::get('get-detailUser', 'UserController@getDetailUser');
    Route::get('user-unlocked', 'UserController@unlockedUser');
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
    Route::get('getUserPerAccount/', 'UserController@dataAccountRegistered');

    Route::get('password_reset','UserController@resetPassword');
    Route::get('pin_reset','UserController@resetPin');

    Route::get('get-dataAOList/{id}', 'AssignController@getListAO');

    Route::get('group-registrasi', 'GroupController@registrasiGroup');
    Route::get('group-get', 'GroupController@getGroup');
    Route::get('get-idgroup', 'GroupController@getIdGroup');
    Route::get('get-dataGroup/{id}', 'GroupController@dataGroup')->name('data-group');
    Route::get('/group/{id}', 'GroupController@groupEdit')->name('group-edit');
    Route::get('group-update', 'GroupController@groupEdit');
    Route::get('group-update/submit', 'GroupController@updateGroup');
    Route::get('getGroupUser/{id}','AssignController@getGroupUser');

    Route::get('addNewUserGroup', 'AssignController@addUserGroup');
    Route::get('delUserGroup', 'AssignController@deleteUserGroup');
    Route::get('delAllUserGroup', 'AssignController@deleteAllUserGroup');

    Route::get('getDataDealer','DealerController@getDealer');
    Route::get('getDealerId','DealerController@getIdDealer');
    Route::get('dealer-registrasi', 'DealerController@registrasiDealer');
    Route::get('dealer-update', 'DealerController@dealerEdit');
    Route::get('dealer-nouser', 'DealerController@dealerNoUser');
    Route::get('dealer-update/submit', 'DealerController@updateDealer');
    Route::get('dealerGetSales', 'DealerController@dealerGetSales');
    Route::get('dealerAssign/add/', 'DealerController@dealerAssignAdd');
    Route::get('dealerAssign/remove/', 'DealerController@dealerAssignRemove');
    Route::get('dealerGetName', 'DealerController@getDealerName');

    Route::get('dealerGetSalesID', 'DealerController@dealerGetSalesID');

    Route::get('getDataSales','SalesController@getSales');
    Route::get('sales-registrasi', 'SalesController@registrasiSales');
    Route::get('sales-update', 'SalesController@salesEdit');
    Route::get('sales-update/submit', 'SalesController@updateSales');
    Route::get('getSalesId','SalesController@getIdSales');
    Route::get('salesGetName', 'SalesController@getSalesName');


    Route::get('getDataCustomer','CustomerController@getCustomer');
    Route::get('getDataFilterCustomer','CustomerController@getFilterCustomer');
    Route::get('sendEmail','CustomerController@sendEmail');

    Route::get('emailTemplate','CustomerController@testEmail');

    Route::get('getDataCustomerDetail','CustomerController@getCustomerDetail');
    Route::get('customerGetName', 'CustomerController@getCustomerName');

});
