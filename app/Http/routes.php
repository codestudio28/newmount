<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// Route::get('/users/{id}/{name}', function ($id,$name) {
//     return 'This is user '.$id.' name: '.$name;
    
// });

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');
Route::get('/property', 'PagesController@property');
Route::get('/property-single', 'PagesController@single');
Route::get('/inquire', 'PagesController@inquiry');

// Route::auth();
// Route::get('/dashboard', 'DashboardController@index');
Route::resource('dashboard','AdminDashboardController');
Route::resource('login','LoginController');
Route::resource('register','RegisterController');
Route::resource('logout','LogoutController@store');
Route::resource('admin','AdministratorController');
Route::resource('admin-removed','AdministratorRemovedController');
Route::resource('admin-custom','AdministratorCustomController');
Route::resource('admin-proptype','PropertyTypeController');
Route::resource('admin-proptype-removed','PropertyTypeRemovedController');
Route::resource('admin-cproptype','PropertyTypeCustomController');
Route::resource('admin-cpaymentscheme','PaymentSchemeCustomController');
Route::resource('admin-paymentscheme','PaymentSchemeController');
Route::resource('admin-paymentscheme-removed','PaymentSchemeRemovedController');
Route::resource('admin-property','PropertyController');
Route::resource('admin-property-removed','PropertyRemovedController');
Route::resource('admin-cproperty','PropertyCustomController');
Route::resource('admin-client','ClientController');
Route::resource('admin-client-removed','ClientRemovedController');
Route::resource('admin-cclient','ClientCustomController');
Route::resource('admin-banner','BannerController');
Route::resource('admin-listings','ListingsController');
Route::resource('admin-about','AboutController');
Route::resource('admin-cms','CMSController');
Route::resource('property-single','SingleController');
Route::resource('admin-inquiry','InquiryController');
Route::resource('admin-buy','BuyController');
Route::resource('admin-collection','CollectionController');
Route::resource('admin-equity','EquityController');
Route::resource('admin-misc','MiscController');
Route::post('admin-buy-single','BuyController@buy');
Route::resource('admin-void','VoidController');
Route::resource('admin-penalty','PenaltyController');
Route::resource('admin-payee','PayeeController');
Route::resource('admin-cpayee','PayeeCustomController');
Route::resource('admin-voucher','VoucherController');
Route::resource('admin-cvoucher','VoucherCustomController');
Route::resource('admin-pdf','PDFController');
Route::resource('print-voucher','VoucherPDFController');
Route::resource('report-property','ReportPropertyController');
Route::resource('report-client','ReportClientController');
Route::resource('report-scheme','ReportSchemeController');
Route::resource('report-collection','ReportCollectionController');
Route::resource('report-inhouse','ReportInhouseController');
Route::resource('report-ccollection','ReportCollectionCustomController');
Route::resource('admin-inhouse','InHouseCollectionController');
Route::resource('report-payable','ReportPayableController');
Route::resource('admin-info','InfoController');