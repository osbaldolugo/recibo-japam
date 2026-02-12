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

Route::get('/', function () {
    return view('auth.login');
})->name('localhost')->middleware(['guest']);

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('welcome', 'HomeController@welcome');

//----------------- REGISTER Vive el reto ------------------------

Route::post('receipt/new/membership', 'AppUserController@saveRegisterViveReto')->name('receipt.register.save');
Route::get('receipt/owner/{contract}/{barcode}', 'AppUserController@getNameOwner')->name('get.owner');
Route::get('recibo/register/preview/email', function () {
    return view('emails.ViveRetoRegistro')->with(['name' => 'NOMBRE DEL TITULAR', 'contract' => 'XXXXX-XXXXX-XXXXXX', 'japam_web' => route('appUser.login.view')]);
});

//----------------- END REGISTER Vive el reto ------------------------
Route::get('recibo/register/preview/email_activacion', function () {
    return view('auth.emails.auth_user_email')->with(['name' => 'NOMBRE DEL TITULAR', 'contract' => 'XXXXX-XXXXX-XXXXXX', 'url' => route('verifyEmail', ['token' => '235ebe0833c10554d01fd1e05dd541182ceb69bb67ab1c34ae66573dd68b8ac65ab2d3cf3dbc1', 'email' => base64_encode('mycorreo@mail.com')])]);
});
Route::get('recibo/register/preview/email_register', function () {
    return view('emails.ViveRetoRegistro')->with(['name' => 'NOMBRE DEL TITULAR', 'contract' => null, 'japam_web' => route('appUser.login.view')]);
});

//Activar la cuenta de correo
Route::get('login/activate/count/{token}/{email?}', 'AppUserController@verifyEMail')->name('verifyEmail');

//--------------------App User panel-------------------------


//Webhook Sr Pago
Route::post('/paymentSucceeded', 'WebhookController@handlePaymentSucceeded');
Route::post('/paymentWebPay', 'WebhookController@getPaymentInfo');

//Auth
Route::get('app-user/login', 'AuthAppUser\LoginController@login')->name('appUser.login.view');
Route::get('app-user/register', 'AuthAppUser\LoginController@register')->name('appUser.register.view');
Route::post('app-user/register', 'AuthAppUser\RegisterController@register')->name('appUser.register');

Route::post('app-user/login', 'AuthAppUser\LoginController@postLogin')->name('appUser.login');
Route::post('app-user/logout', 'AuthAppUser\LoginController@logout')->name('appUser.logout');

//Reset Password
Route::post('app-user/password/email', 'AuthAppUser\ForgotPasswordController@sendResetLinkEmail')->name('appUser.password.email');
Route::get('app-user/password/reset', 'AuthAppUser\ForgotPasswordController@showLinkRequestForm')->name('appUser.password.request');
Route::post('app-user/password/reset', 'AuthAppUser\ResetPasswordController@reset');
Route::get('app-user/password/reset/{token}', 'AuthAppUser\ResetPasswordController@showResetForm')->name('appUser.password.reset');

Route::get('receipts/searchGuest', 'ReceiptController@searchGuest')->name('receipts.searchGuest');
Route::post('receipts/consult', 'ReceiptController@consult')->name('receipts.consult');
Route::post('receipts/processPay/{type}', 'ReceiptController@processPay');
Route::get('receipts/generateReceiptPDF/{id}', 'ReceiptController@generateReceiptPDF');

    Route::get('receipts', array(
        'as' => 'receipts.indexWeb',
        'middleware' => 'appUser',
        'uses' => 'ReceiptController@index'
    ));
    
    Route::post('receipts/store', 'ReceiptController@store');
    Route::post('receipts/{id}/editAlias', 'ReceiptController@editAlias');
    Route::get('receipts/pay/{id}', 'ReceiptController@pay')->name('receipts.pay');
    Route::get('receipts/{id}/viewPays', 'ReceiptController@viewPays')->name('receipts.viewPays');
    
    Route::get('receipts/delete/{id}', 'ReceiptController@deleteid')->name('delete.receipts');

    //  preubas para panel y jalar un form adentro
    Route::get('queja/crear', 'QuejaController@complainCreate')->name('complain.create');
    Route::get('complain/create', 'ComplaintController@complainCreate')->name('complain.create');
    Route::get('schedule/request', 'ComplaintController@scheduleRequest')->name('schedule.request');
    Route::get('userProfile', 'AppUserController@userProfile')->name('appUser.userProfile');
    Route::get('paysMethods', 'PayMethodController@index');

//User Card routes
    Route::get('appUserCards', 'AppUserCardController@index')->name('appUserCards.index');
    Route::post('appUserCards/store', 'AppUserCardController@store')->name('appUserCards.store');
    Route::delete('appUserCards/{id}/delete', 'AppUserCardController@delete')->name('appUserCards.delete');
    Route::get('appUserCards/{id}/default', 'AppUserCardController@defaultCard')->name('appUserCards.default');
//}); END MIDDLEWARE
//------------------End App User Panel--------------------------


//TicketIT
Route::group(['middleware' => ['auth']], function () {

    Route::get('/error', function () {
        return view('admin.access_denied');
    })->name('access.denied');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/getChartTicket', 'HomeController@getChartTicket')->name('home.getChartTicket');

    Route::resource('people', 'PeopleController');

    Route::post('/payControls/getTotals', 'PayControlController@getTotals')->name('getTotals');
    Route::resource('payControls', 'PayControlController');

    Route::get('appSettings/getPaymentStatus', 'AppSettingsController@getPaymentStatus');
    Route::resource('appSettings', 'AppSettingsController');

    Route::get('notifications/sendNotification', 'NotificationController@sendNotification');
    Route::resource('notifications', 'NotificationController');

    Route::get('branchOffices/deleteSchedule/{id}', 'BranchOfficeController@deleteSchedule');
    Route::get('branchOffices/getDetailsBranchOffice/{id}', 'BranchOfficeController@edit');
    Route::resource('branchOffices', 'BranchOfficeController');

    Route::get('appSliderHomes/getImage/{id}', 'AppSliderHomeController@getImage');
    Route::get('appSliderHomes/sliderLoad', 'AppSliderHomeController@sliderLoad');
    Route::resource('appSliderHomes', 'AppSliderHomeController');

    Route::resource('appUsers', 'AppUserController');

    Route::get('mapping/app', 'MappingController@index_app')->name("mapping.index_app");
    Route::get('mapping', 'MappingController@index')->name("mapping.index");
    Route::post('mapping', 'MappingController@store')->name("mapping.store");
    Route::get('/getRoutes/{group}', 'MappingController@getRoutes');
    Route::get('/getStops/{id}', 'MappingController@getStops');
    Route::post('/getPlaces', 'MappingController@getPlaces');
    Route::post('/nearbyStops', 'MappingController@nearbyStops');

    //TICKETS
    Route::get("tickets/data/{id?}", 'TicketsController@data')->name("tickets.data");
    Route::get("tickets/reasign/{id}/{agent_id}/{category_id}", 'TicketsController@reAsing')->name('tickets.reasign');
    Route::post("tickets/merge/{id}", 'TicketsController@mergeTicket')->name('tickets.merge');
    Route::get("tickets/merge/search/{id_ticket}/{tickets?}", 'TicketsController@searchMergeTicket')->name('tickets.merge.search');
    Route::get("tickets/merge/{ticket_father}/revert/{ticket_son}", 'TicketsController@mergeTicketRevert')->name('tickets.merge.revert');

    Route::get('tickets/listComments/{id}','TicketsController@listComments')->name('tickets.listComments');
    Route::get('tickets/listSimilar/{latitude}/{longitude}','TicketsController@getListSimilarTickets')->name('tickets.listSimilar');
    Route::get('tickets/send/reminder/{ticket_id}','TicketsController@sendReminder')->name('tickets.sendReminder');
    Route::get('tickets/subscribe/{ticket_id}/{subscribe}','TicketsController@subscribeUnsubscribreTicket')->name('tickets.subscribe');

    Route::resource("tickets", 'TicketsController');
    Route::get('tickets/get/holder/{contract}', 'TicketsController@getNameHolder')->name('tickets.holder.contract');

    //Ticket complete route for permitted user.
    Route::get("tickets/{id}/complete", 'TicketsController@complete')->name("tickets.complete");

    //Ticket reopen route for permitted user.
    Route::get("tickets/{id}/reopen", 'TicketsController@reopen')->name("tickets.reopen");
    //});

    //Ticket Comments public route
    Route::resource("tickets-comment", 'CommentsController');
    Route::post('tickets-comment/send/image', 'CommentsController@sendImage')->name('tickets-comment.image');

    Route::group(['middleware' => 'IsAgent'], function () {
        //API return list of agents in particular category
        Route::get('tickets/agents/list/{category_id?}/{ticket_id?}', 'TicketsController@agentSelectList')->name('tickets.agentselectlist');
    });

    Route::group(['middleware' => 'IsAdmin'], function () {
        //Ticket admin index route (ex. http://url/tickets-admin/)
        Route::get('tickets-admin/indicator/{indicator_period?}', 'DashboardController@index')->name('tickets-admin.dashboard.indicator');

        Route::get('tickets-admin', 'DashboardController@index');

        //Ticket statuses admin routes (ex. http://url/tickets-admin/status)
        Route::resource("tickets-admin/status", 'StatusesController', [
            'names' => [
                'index' => "tickets-admin.status.index",
                'store' => "tickets-admin.status.store",
                'create' => "tickets-admin.status.create",
                'update' => "tickets-admin.status.update",
                'show' => "tickets-admin.status.show",
                'destroy' => "tickets-admin.status.destroy",
                'edit' => "tickets-admin.status.edit",
            ],
        ]);

        //Ticket priorities admin routes (ex. http://url/tickets-admin/priority)
        Route::resource("tickets-admin/priority", 'PrioritiesController', [
            'names' => [
                'index' => "tickets-admin.priority.index",
                'store' => "tickets-admin.priority.store",
                'create' => "tickets-admin.priority.create",
                'update' => "tickets-admin.priority.update",
                'show' => "tickets-admin.priority.show",
                'destroy' => "tickets-admin.priority.destroy",
                'edit' => "tickets-admin.priority.edit",
            ],
        ]);

        //Agents management routes (ex. http://url/tickets-admin/agent)
        Route::resource("tickets-admin/agent", 'AgentsController', [
            'names' => [
                'index' => "tickets-admin.agent.index",
                'store' => "tickets-admin.agent.store",
                'create' => "tickets-admin.agent.create",
                'update' => "tickets-admin.agent.update",
                'show' => "tickets-admin.agent.show",
                'destroy' => "tickets-admin.agent.destroy",
                'edit' => "tickets-admin.agent.edit",
            ],
        ]);

        //Agents management routes (ex. http://url/tickets-admin/agent)
        Route::resource("tickets-admin/category", 'CategoriesController', [
            'names' => [
                'index' => "tickets-admin.category.index",
                'store' => "tickets-admin.category.store",
                'create' => "tickets-admin.category.create",
                'update' => "tickets-admin.category.update",
                'show' => "tickets-admin.category.show",
                'destroy' => "tickets-admin.category.destroy",
                'edit' => "tickets-admin.category.edit",
            ],
        ]);

        //Settings configuration routes (ex. http://url/tickets-admin/configuration)
        Route::resource("tickets-admin/configuration", 'ConfigurationsController', [
            'names' => [
                'index' => "tickets-admin.configuration.index",
                'store' => "tickets-admin.configuration.store",
                'create' => "tickets-admin.configuration.create",
                'update' => "tickets-admin.configuration.update",
                'show' => "tickets-admin.configuration.show",
                'destroy' => "tickets-admin.configuration.destroy",
                'edit' => "tickets-admin.configuration.edit",
            ],
        ]);

        //Administrators configuration routes (ex. http://url/tickets-admin/administrators)
        Route::resource("tickets-admin/administrator", 'AdministratorsController', [
            'names' => [
                'index' => "tickets-admin.administrator.index",
                'store' => "tickets-admin.administrator.store",
                'create' => "tickets-admin.administrator.create",
                'update' => "tickets-admin.administrator.update",
                'show' => "tickets-admin.administrator.show",
                'destroy' => "tickets-admin.administrator.destroy",
                'edit' => "tickets-admin.administrator.edit",
            ],
        ]);

        //Administration of WEB PANEL users
        Route::get('admin/users/list', 'AdministratorsController@usersList')->name('admin.users');
        Route::get('admin/users/is_admin/{id}/{is_admin}', 'AdministratorsController@updateAdministrator');
        Route::get('admin/users/is_agent/{id}/{is_agent}', 'AdministratorsController@updateAgent');
        Route::post('admin/users/create', 'AdministratorsController@storeUser')->name('admin.users.store');
        Route::get('admin/users/update/{id_user}', 'AdministratorsController@editUser')->name('admin.users.edit');
        Route::post('admin/users/update/{id_user}', 'AdministratorsController@updateUser')->name('admin.users.update');
        Route::delete('admin/users/delete/{id_user}', 'AdministratorsController@deleteUser')->name('admin.users.delete');
        Route::get('admin/users/restore/{id_user}', 'AdministratorsController@restoreUser')->name('admin.users.restore');

    });

    //AppTicket
    Route::get('appTickets/createTicket/{appTicket_id}', 'TicketsController@createTicket')->name("appTickets.createTicket");
    Route::resource('appTickets', 'AppTicketController');

    Route::get('incidents/{id}/getSteps', 'IncidentsController@getSteps')->name("incidents.getSteps");
    Route::resource('incidents', 'IncidentsController');

    //Sector
    Route::post('sector/getPlacesTicket', 'MappingController@getPlacesTicket')->name('sector.map.getTickets');
    Route::get('sector/getPlacesTicketApp', 'MappingController@getPlacesTicketApp');
    Route::get('sector/get/suburbs/{sector_id}','MappingController@getSuburbs')->name('sector.map.getSuburbs');
    Route::post('sector/addSuburb', 'SectorController@addSuburb');
    Route::post('sector/getDots', 'SectorController@getDots');
    Route::resource('sector', 'SectorController');

    Route::resource('suburbs', 'SuburbController');

    Route::resource('peopleUnloggeds', 'PeopleUnloggedController');

    //PMO (Proyect Managment Office) Works
    Route::get('pMOWorkTables/{id}/mappingCreate', 'PMOWorkTableController@mappingCreate')->name("pmoWorkTables.mappingCreate");
    Route::get('pMOWorkTables/{id}/orderWorkCreate', 'PMOWorkTableController@orderWorkCreate')->name("pmoWorkTables.orderWorkCreate");
    Route::get('pMOWorkTables/{id}/orderWorkClose', 'PMOWorkTableController@orderWorkClose')->name("pmoWorkTables.orderWorkClose");
    Route::get('pMOWorkTables/{id}/getWorkOrder', 'PMOWorkTableController@getWorkOrder')->name("pmoWorkTables.getWorkOrder");
    Route::post('pMOWorkTables/createPDF', 'PMOWorkTableController@createPDF')->name("pmoWorkTables.createPDF");
    Route::get('pMOWorkTables/asignados', 'PMOWorkTableController@index_asignados')->name("pmoWorkTables.index_asignados");
    Route::post('pMOWorkTables/downloadFile', 'PMOWorkTableController@downloadFile')->name("pMOWorkTables.downloadFile");
    Route::post('pMOWorkTables/change_status', 'PMOWorkTableController@change_status')->name("pMOWorkTables.change_status");
    Route::resource('pMOWorkTables', 'PMOWorkTableController');

    Route::resource('pMOWorks', 'PMOWorkController');

    Route::resource('pMOWorkers', 'PMOWorkerController');

    Route::resource('pMOMaterials', 'PMOMaterialController');

    Route::resource('pMOWorkTypes', 'PMOWorkTypeController');

    Route::resource('pMOEquipments', 'PMOEquipmentController');

    /*Push notification*/
    Route::get('push/isAdmin', 'NotificationsController@isAdmin');
    Route::get('push/inArea', 'NotificationsController@inArea');
    Route::get('push/inTicket', 'NotificationsController@inTicket');
    Route::get('push/inOT', 'NotificationsController@inOT');


    Route::resource('pMOSpecialities', 'PMOSpecialityController');
    Route::resource('pMOWorkTables', 'PMOWorkTableController');
    Route::resource('pMOWorkTableFinishes', 'PMOWorkTableFinishController');

    Route::resource('priorities', 'PriorityController');

    Route::resource('categories', 'CategoryController');
    Route::get('categories/{category_id}/update/{executor}', 'CategoryController@updateExecutor')->name('categories.executor');
});

Route::get("view/email_complaint", function () {
    $mail_data = ['name' => 'Nombre del informante', 'type_string' => 'un Reporte', 'type' => 'Reporte', 'address' => 'Ubicación del problema', 'phone_number' => 'Teléfono del usuario que reporta', 'complaint' => 'Breve explicación ingresada por el usuario (El usuario detalla lo que quiere reportar)'];
   return view("emails.create_complaint")->with($mail_data);
});

Route::get('complaints/indexDate', 'ComplaintController@indexDate')->name("complaints.indexDate");
Route::resource('complaints', 'ComplaintController');

Route::resource('pMOWorkOrderSectorDots', 'PMOWorkOrderSectorDotsController');

Route::resource('pMOWorkOrderSectorDots', 'PMOWorkOrderSectorDotsController');

Route::resource('pMOWorkOrderSectorDots', 'PMOWorkOrderSectorDotsController');

Route::resource('pMOWorkOrderSuburbs', 'PMOWorkOrderSuburbsController');

Route::get('Bienvenido', 'ReceiptController@bienvenida')->name('japam.Home');



Route::get('/generarreportefalta', 'AppTicketController@openviewfalta')->name('falta.servicio');
Route::post('faltaServicio', array(
    'as' => 'guardarreporteFS',
    'uses' => 'AppTicketController@faltaServicio'
    ));
Route::get('/generarreportefuga', 'AppTicketController@openviewfugas')->name('reporte.fuga');
Route::post('reportefuga', array(
    'as' => 'guardarreporteFuga',
    'uses' => 'AppTicketController@guardarreportefuga'
));


Route::get('/generarreportetomasc', 'AppTicketController@openviewtomasc')->name('toma.clandestina');
Route::post('reportetomaC', array(
    'as' => 'guardarreporteToma',
    'uses' => 'AppTicketController@guardarreportetoma'
));

Route::get('japam/metrics', array(
    'as' => 'onclicks.metrics',
    'uses' => 'OnClickController@index'
));

Route::get('clicks', array(
    'as' => 'onclicks',
    'uses' => 'OnClickController@create'
));
Route::post('clicks', array(
    'as' => 'onclicks.save',
    'uses' => 'OnClickController@store'
));

Route::get('generic_page', function (){

    return view('generic_page');
});

Route::post('/saveClick', array(
    'as' => 'saveClick',
    'uses' => 'MetricsController@store'
));

Route::post('/japam/metrics/consultaDeFechas', array(
   'as' => 'consultaDeFechas',
   'uses' => 'MetricsController@consultaDeFechas'
));

Route::post('/japam/metrics/quejas', array(
    'as' => 'consultaquejas',
    'uses' => 'OnClickController@consultaDeFechas'
));

Route::post('/japam/metrics/reportes', array(
    'as' => 'consultareportes',
    'uses' => 'OnClickController@consultaDeReportes'
));

Route::post('/japam/metrics/denuncias', array(
    'as' => 'consultadenuncias',
    'uses' => 'OnClickController@consultaDeDenuncias'
));

Route::post('/japam/metrics/descargas', array(
    'as' => 'consultadenuncias',
    'uses' => 'MetricsController@consultaDeDescargas'
));