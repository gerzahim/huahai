<?php
//Auth::routes();
#Installation script Routes

//web.php

Route::get('mobile','MobileController@create');
Route::post('mobile','MobileController@store');

Route::post('/addcheckin', [
    'uses' => 'AjaxController@getAddCheckIn',
    'as' => 'addcheckin'
]);


Route::group(array('prefix'=>'install','middleware'=>'install'),function() {
    Route::get('/','InstallController@index');
    Route::get('/database','InstallController@getDatabase');
    Route::post('/database','InstallController@postDatabase');
    Route::get('/user','InstallController@getUser');
    Route::post('/user','InstallController@postUser');
});

Route::group(['middleware' => 'install'], function(){
    Route::group(['prefix'=>'clientarea'],function(){
        Route::get('login', 'ClientArea\Auth\AuthController@getLogin')->name('client_login');
        Route::post('login', 'ClientArea\Auth\AuthController@postLogin');
        Route::get('logout', 'ClientArea\Auth\AuthController@getLogout')->name('client_logout');
        // Password Reset Routes...
        Route::get('password/reset', 'ClientArea\Auth\ForgotPasswordController@showLinkRequestForm');
        Route::post('password/email', 'ClientArea\Auth\ForgotPasswordController@sendResetLinkEmail');
        Route::get('password/reset/{token}', 'ClientArea\Auth\ResetPasswordController@showResetForm');
        Route::post('password/reset', 'ClientArea\Auth\ResetPasswordController@reset');
        Route::group(['middleware' => 'client'], function() {
            Route::get('/', 'ClientArea\HomeController@index');
            Route::get('home', 'ClientArea\HomeController@index')->name('client_dashboard');
            Route::resource('cinvoices', 'ClientArea\InvoicesController', array('only' => array('index', 'show')));
            Route::resource('cestimates', 'ClientArea\EstimatesController', array('only' => array('index', 'show')));
            Route::resource('cpayments', 'ClientArea\PaymentsController', array('only' => array('index', 'show')));
            Route::post('getCheckout', ['as'=>'getCheckout','uses'=>'ClientArea\CheckoutController@getCheckout']);
            Route::post('getDone', ['as'=>'getDone','uses'=>'ClientArea\CheckoutController@getDone']);
            Route::get('getCancel/{id}', ['as'=>'getCancel','uses'=>'ClientArea\CheckoutController@getCancel']);
            Route::post('paypal_notify', ['as'=>'paypal_notify','uses'=>'ClientArea\CheckoutController@paypalNotify']);
            Route::get('stripecheckout/{id}', ['as'=>'stripecheckout','uses'=>'ClientArea\CheckoutController@stripeCheckout']);
            Route::post('stripecheckout', ['as'=>'stripesuccess','uses'=>'ClientArea\CheckoutController@stripeSuccess']);
            Route::get('payment_methods/{invoice_id}', ['uses' => 'ClientArea\PaymentMethodsController@index']);
            Route::get('cprofile', ['uses' => 'ClientArea\ProfileController@edit']);
            Route::post('cprofile', ['uses' => 'ClientArea\ProfileController@update']);
            Route::get('estimatepdf/{id}', 'ClientArea\EstimatesController@estimatePdf')->name('estimatepdf');
            Route::get('invoicepdf/{id}', 'ClientArea\InvoicesController@invoicePdf')->name('invoicepdf');
            Route::get('lang/{lang}', ['as'=>'client_lang_switch', 'uses'=>'LanguageController@switchLang']);
            # reports resource
            Route::group(array('prefix'=>'reports'),function(){
                Route::get('/', 'ClientArea\ReportsController@index');
                Route::post('general', 'ClientArea\ReportsController@general_summary');
                Route::post('payment_summary', 'ClientArea\ReportsController@payment_summary');
                Route::post('client_statement', 'ClientArea\ReportsController@client_statement');
                Route::post('invoices_report', 'ClientArea\ReportsController@invoices_report');
            });
        });
    });
    Route::get('login', 'Auth\AuthController@showLoginForm')->name('admin_login');
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('logout', 'Auth\AuthController@getLogout')->name('admin_logout');
    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('recurring', 'RecurringInvoicesController@index');
    Route::group(['middleware' => 'auth'], function(){
        #home controller
        Route::get('/',   'HomeController@index')->name('home');
        Route::get('home','HomeController@index');
        #Resources Routes
        Route::resources([
            'users'     => 'UsersController',
            'clients'   => 'ClientsController',
            'vendors'   => 'VendorsController',
            'invoices'  => 'InvoicesController',
            'products'  => 'ProductsController',
            'inventory'  => 'TransactionController',
            'expenses'  => 'ExpensesController',
            'estimates' => 'EstimatesController',
            'payments'  => 'PaymentsController',
            'couriers'  => 'CouriersController',
            'product_category'  => 'ProductCategoryController',
            'expense_category'  => 'ExpenseCategoryController',
        ]);
        #Grouped Routes
        Route::group(['prefix'=>'settings'],function(){
            Route::resource('company', 'SettingsController', array('only' => array('index', 'store', 'update') ));
            Route::resource('invoice', 'InvoiceSettingsController', array('only' => array('index', 'store', 'update') ));
            Route::resource('email', 'EmailSettingsController', array('only' => array('index', 'store', 'update') ));
            Route::resource('estimate', 'EstimateSettingsController', array('only' => array('index', 'store', 'update') ));
            Route::resource('tax', 'TaxSettingsController');
            Route::resource('templates', 'TemplatesController', array('only' => array('index','show', 'store', 'update') ));
            Route::resource('number', 'NumberSettingsController', array('only' => array('index', 'store', 'update') ));
            Route::resource('payment', 'PaymentMethodsController', array('except' => array('show', 'create') ));
            Route::resource('currency', 'CurrencyController', array('except' => array('show') ));
            Route::resource('roles', 'RolesController', array('except' => array('create') ));
            Route::resource('permissions', 'PermissionsController', array('except' => array('show', 'create') ));
            Route::resource('translations', 'TranslationsController');
            Route::post('assignPermission', 'RolesController@assignPermission');
            Route::post('paypal_details', 'PaymentMethodsController@postPaypalDetails');
            Route::post('stripe_details', 'PaymentMethodsController@postStripeDetails');
            Route::get('update_exchange_rates', ['as'=>'update_exchange_rates','uses'=>'CurrencyController@updateCurrencyRates']);
            Route::post('/verify','InstallController@postVerify');
        });

        # Inventory resource
        //Route::group(array('prefix'=>'inventory'),function(){
          Route::get('checkin', 'TransactionController@checkinProducts')->name('checkin');
          Route::post('checkin', 'TransactionController@saveCheckinProducts')->name('checkin');

          Route::get('checkout', 'TransactionController@checkoutProducts')->name('checkout');
          Route::post('checkout', 'TransactionController@saveCheckoutProducts')->name('checkout');

          Route::get('transactions', 'TransactionController@listTransactions')->name('transactions');
          Route::get('transaction/print/{uuid}', 'TransactionController@printTransaction')->name('transaction.print');
        //});
        # estimates resource
        Route::group(array('prefix'=>'estimates'),function(){
            Route::post('deleteItem', 'EstimatesController@deleteItem');
            Route::get('pdf/{id}', 'EstimatesController@estimatePdf');
            Route::get('send/{id}', 'EstimatesController@send');
            Route::post('makeInvoice', 'EstimatesController@makeInvoice');
        });
        # invoices resource
        Route::group(array('prefix'=>'invoices'),function(){
            Route::post('deleteItem', 'InvoicesController@deleteItem');
            Route::post('ajaxSearch', 'InvoicesController@ajaxSearch');
            Route::get('pdf/{id}', 'InvoicesController@invoicePdf');
            Route::get('send/{id}', 'InvoicesController@send');
        });
        # reports resource
        Route::group(array('prefix'=>'reports'),function(){
            Route::get('/', 'ReportsController@index');
            Route::post('general', 'ReportsController@general_summary');
            Route::post('payment_summary', 'ReportsController@payment_summary');
            Route::post('client_statement', 'ReportsController@client_statement');
            Route::post('invoices_report', 'ReportsController@invoices_report');
            Route::post('expenses_report', 'ReportsController@expenses_report');
        });
        # products custom routes
        Route::get('add_files/{id}', 'ProductsController@add_files')->name('products.add_files');
        Route::post('save_files', 'ProductsController@save_files')->name('products.save_files');
        Route::get('delete_file/{id}', 'ProductsController@delete_file')->name('products.delete_file');
        Route::get('products_modal', 'ProductsController@products_modal');
        Route::post('process_products_selections', 'ProductsController@process_products_selections');
        Route::get('add_serial_number_modal', 'ProductsController@add_serial_number_modal');
        Route::post('save_serial_number', 'TransactionController@save_serial_number');        
        Route::post('checkProduct', 'TransactionController@checkQuantityProduct');        
        Route::post('save_secuencial_serial_number', 'TransactionController@save_secuencial_serial_number');        
        Route::post('show_serial_numbers', 'ProductsController@show_serial_numbers');
        Route::post('delete_serial_number', 'TransactionController@delete_serial_number');

        # Profile
        Route::get('profile', ['uses' => 'ProfileController@edit']);
        Route::get('lang/{lang}', ['as'=>'admin_lang_switch', 'uses'=>'LanguageController@switchLang']);
        Route::post('profile', ['uses' => 'ProfileController@update']);
        Route::post('reports/ajaxData', 'ReportsController@ajaxData');
    });
});
