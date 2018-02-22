<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::auth();
Route::get('/logout', 'Auth\LoginController@logout');
Route::group(['middleware' => ['auth']], function () {
    
    /**
     * Main
     */
        Route::get('/', 'PagesController@dashboard');
        Route::get('dashboard', 'PagesController@dashboard')->name('dashboard');
        
    /**
     * Users
     */
    Route::group(['prefix' => 'users'], function () {
        Route::get('/data', 'UsersController@anyData')->name('users.data');
        Route::get('/taskdata/{id}', 'UsersController@taskData')->name('users.taskdata');
        Route::get('/leaddata/{id}', 'UsersController@leadData')->name('users.leaddata');
        Route::get('/clientdata/{id}', 'UsersController@clientData')->name('users.clientdata');
        Route::get('/users', 'UsersController@users')->name('users.users');
    });
        Route::resource('users', 'UsersController');

    /**
     * Tickets
     */
    Route::group(['prefix' => 'tickets'], function () {
    });
    Route::patch('descriptions/leaderconfirm/{id}', 'DescriptionsController@leaderConfirm');
    Route::patch('descriptions/effectivenessasset/{id}', 'DescriptionsController@effectivenessAsset');
    Route::patch('troubleshoots/assigntroubeshooter/{id}', 'TroubleshootsController@assignTroubleshooter');
    Route::patch('troubleshoots/approve/{id}', 'TroubleshootsController@approve');
    Route::patch('troubleshoots/evaluate/{id}', 'TroubleshootsController@evaluate');
    Route::patch('preventions/assignproposer/{id}', 'PreventionsController@assignProposer');
    Route::patch('preventions/assignapprover/{id}', 'PreventionsController@assignApprover');
    Route::patch('preventions/approve/{id}', 'PreventionsController@approve');
    Route::resource('descriptions', 'DescriptionsController');
    Route::resource('troubleshoots', 'TroubleshootsController');
    Route::resource('preventions', 'PreventionsController');
    Route::post('troubleshootactions/{id}/store',
        ['as' => 'troubleshootactions.store', 'uses' => 'TroubleshootActionsController@store']);
    Route::resource('troubleshootactions', 'TroubleshootActionsController', ['except' => ['store'] ]);
    Route::post('preventionactions/{id}/store',
        ['as' => 'preventionactions.store', 'uses' => 'PreventionActionsController@store']);
    Route::resource('preventiontactions', 'PreventionActionsController', ['except' => ['store'] ]);
    Route::resource('tickets', 'TicketsController');

	 /**
     * Roles
     */
        Route::resource('roles', 'RolesController');
    /**
     * Clients
     */
    Route::group(['prefix' => 'clients'], function () {
        Route::get('/data', 'ClientsController@anyData')->name('clients.data');
        Route::post('/create/cvrapi', 'ClientsController@cvrapiStart');
        Route::post('/upload/{id}', 'DocumentsController@upload');
        Route::patch('/updateassign/{id}', 'ClientsController@updateAssign');
    });
        Route::resource('clients', 'ClientsController');
	    Route::resource('documents', 'DocumentsController');
	
      
    /**
     * Tasks
     */
    Route::group(['prefix' => 'tasks'], function () {
        Route::get('/data', 'TasksController@anyData')->name('tasks.data');
        Route::patch('/updatestatus/{id}', 'TasksController@updateStatus');
        Route::patch('/updateassign/{id}', 'TasksController@updateAssign');
        Route::post('/updatetime/{id}', 'TasksController@updateTime');
    });
        Route::resource('tasks', 'TasksController');

    /**
     * Leads
     */
    Route::group(['prefix' => 'leads'], function () {
        Route::get('/data', 'LeadsController@anyData')->name('leads.data');
        Route::patch('/updateassign/{id}', 'LeadsController@updateAssign');
        Route::patch('/updatestatus/{id}', 'LeadsController@updateStatus');
        Route::patch('/updatefollowup/{id}', 'LeadsController@updateFollowup')->name('leads.followup');
    });
        Route::resource('leads', 'LeadsController');
        Route::post('/comments/{type}/{id}', 'CommentController@store');
    /**
     * Settings
     */
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'SettingsController@index')->name('settings.index');
        Route::patch('/permissionsUpdate', 'SettingsController@permissionsUpdate');
        Route::patch('/overall', 'SettingsController@updateOverall');
    });

    /**
     * Departments
     */
        Route::resource('departments', 'DepartmentsController'); 

    /**
     * Integrations
     */
    Route::group(['prefix' => 'integrations'], function () {
        Route::get('Integration/slack', 'IntegrationsController@slack');
    });
        Route::resource('integrations', 'IntegrationsController');

    /**
     * Notifications
     */
    Route::group(['prefix' => 'notifications'], function () {
        Route::post('/markread', 'NotificationsController@markRead')->name('notification.read');
        Route::get('/markall', 'NotificationsController@markAll');
        Route::get('/{id}', 'NotificationsController@markRead');
    });

    /**
     * Invoices
     */
    Route::group(['prefix' => 'invoices'], function () {
        Route::post('/updatepayment/{id}', 'InvoicesController@updatePayment')->name('invoice.payment.date');
        Route::post('/reopenpayment/{id}', 'InvoicesController@reopenPayment')->name('invoice.payment.reopen');
        Route::post('/sentinvoice/{id}', 'InvoicesController@updateSentStatus')->name('invoice.sent');
        Route::post('/newitem/{id}', 'InvoicesController@newItem')->name('invoice.new.item');
    });
        Route::resource('invoices', 'InvoicesController');
});
