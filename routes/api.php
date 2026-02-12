<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/ticketStatus/{ticket_id}','Api\AppTicketController@ticketStatus');
Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');
Route::post('loginIntern', 'Api\AuthIntern\LoginController@login');
Route::post('refreshIntern', 'Api\AuthIntern\LoginController@refresh');
Route::group(['namespace'=>'Api'], function () {

    header('Access-Control-Allow-Origin: *');
     header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
     header('Access-Control-Allow-Headers: Authorization, X-Requested-With,  Content-Type, Accept');
     header("Cache-Control: no-cache");//Dont cache
     header("Pragma: no-cache");//Dont cache

     /*Routes Unauthenticated User*/
    //AppUser
    Route::post('user/recoverPassword', 'UserController@recoverPassword');

    //Ticket
    Route::post('tickets/generateComplaint', 'TicketController@generateComplaint');
    Route::resource('tickets', 'TicketController');

    //Pays
    Route::post('pay/generatePayWithCard', 'PayController@generatePayWithCard');
    Route::post('pay/generateReferenceStore', 'PayController@generateReferenceStore');


    //Receipts
    Route::get('receipts/getReceiptInformation/{contract}', 'ReceiptController@getReceiptInformation');
    Route::get('receipts/getReceiptAgreements/{contract}', 'ReceiptController@getReceiptAgreements');

    //Routes for Notifications
    Route::get('notifications/getNotifications', 'NotificationController@getNotifications');

    //Routes for BranchOffice
    Route::get('branchOffice/getBranches', 'BranchOfficeController@getBranches');
    Route::get('branchOffice/getDetailsBranchOffice/{branchOffice}', 'BranchOfficeController@getDetailsBranchOffice');

    //Routes for Slider´s
    Route::get('appSliderHome/getImagesSliderHome', 'AppSliderHomeController@getImagesSliderHome');


    //User Controller
    Route::post('user/validateIfExists', 'UserController@validateIfExists');

    //Route for metrics api register click video, click view pfd and click at bank
    Route::post('/saveClick', array(
        'as' => 'saveClick',
        'uses' => 'MetricsController@store'
    ));

    /*Routes Authenticated User*/
    Route::middleware(['auth:apiweb'])->group(function () {

        //Comments Routes
        Route::get('tickets/{idTicket}/comments', 'TicketController@getComments');
        Route::resource('comments', 'CommentsController');

        //Project Managment Orders (PMO)
        Route::resource('pMOWorks', 'PMOWorkController');

        Route::resource('pMOWorkers', 'PMOWorkerController');

        Route::resource('pMOMaterials', 'PMOMaterialController');

        Route::resource('pMOWorks', 'PMOWorkController');

        Route::resource('pMOWorkTypes', 'PMOWorkTypeController');

        Route::resource('pMOEquipments', 'PMOEquipmentController');

        //AppUser
        Route::post('userIntern/validateOldPassword', 'UsersController@validateOldPassword');
        Route::post('userIntern/updatePassword', 'UsersController@updatePassword');
        Route::post('userIntern/validateEmail', 'UsersController@validateEmail');
        Route::post('userIntern/updateUser', 'UsersController@updateUser');
        Route::get('userIntern', 'UsersController@index');
        Route::get('logoutIntern', 'Auth\LoginController@logout');

    });

    /*Routes Authenticated User*/
    Route::middleware(['auth:api'])->group(function () {
        //AppUser
        Route::post('user/registerFirebaseToken', 'UserController@registerFirebaseToken');
        Route::post('user/validateOldPassword', 'UserController@validateOldPassword');
        Route::post('user/updatePassword', 'UserController@updatePassword');
        Route::post('user/validateEmail', 'UserController@validateEmail');
        Route::post('user/updateUser', 'UserController@updateUser');
        Route::get('user', 'UserController@index');
        Route::get('logout', 'Auth\LoginController@logout');

        //Receipts
        Route::get('receipt/delete/{id}', 'ReceiptController@delete');
        Route::post('receipt/changeAlias', 'ReceiptController@changeAlias');
        
        Route::resource('receipts', 'ReceiptController');
    });
    
    Route::get('japam/generateReceiptPDF/{receiptId}', 'ReceiptController@generateReceiptPDF');
});
