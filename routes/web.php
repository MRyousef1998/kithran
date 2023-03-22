<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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
Auth::routes();
//Route::resource('produ', 'App\Http\Controllers\InvoicesController');
// Route::get('coffe', 'App\Http\Controllers\ProductController');

// Route::resource('sections', 'App\Http\Controllers\SectionsController');
// Route::resource('products', 'App\Http\Controllers\ProductController');
// Route::get('/section/{id}', 'App\Http\Controllers\InvoicesController@getproducts');

// Route::get('/InvoicesDetails/{id}', 'App\Http\Controllers\InvoicesDetailsController@edit');

Route::get('download/{orderNumber}/{file_name}', 'App\Http\Controllers\OrderDetailController@get_file');

 Route::get('View_file/{orderNumber}/{file_name}', 'App\Http\Controllers\OrderDetailController@open_file');
 Route::post('delete_file', 'App\Http\Controllers\OrderDetailController@destroy')->name('delete_file');

// Route::post('delete_file', 'App\Http\Controllers\InvoicesDetailsController@destroy')->name('delete_file');


Route::post('addAttachments', 'App\Http\Controllers\OrderDetailController@addAttachments')->name('addAttachments');



// Route::get('/edit_invoice/{id}', 'App\Http\Controllers\InvoicesController@edit');

// Route::get('/Status_show/{id}', 'App\Http\Controllers\InvoicesController@show')->name('Status_show');

// Route::post('/Status_Update/{id}', 'App\Http\Controllers\InvoicesController@Status_Update')->name('Status_Update');


// Route::get('Invoice_Paid','App\Http\Controllers\InvoicesController@Invoice_Paid');

// Route::get('Invoice_UnPaid','App\Http\Controllers\InvoicesController@Invoice_UnPaid');

// Route::get('Invoice_Partial','App\Http\Controllers\InvoicesController@Invoice_Partial');
// Route::resource('Archive', 'App\Http\Controllers\InvoiceAchiveController');


Route::get('/', function () {
    return view('auth.login
    ');
});
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','App\Http\Controllers\RoleController');
    Route::resource('users','App\Http\Controllers\UserController');
    Route::resource('products','ProductController');
    });

Route::resource('all_product', 'App\Http\Controllers\ProductDetailController');
Route::get('all_machine/{id}', 'App\Http\Controllers\ProductController@index');
Route::resource('all_machine/add_machine', 'App\Http\Controllers\ProductController');
Route::post('addProducts', 'App\Http\Controllers\ProductController@store')->name('addProducts');

Route::resource('today_account_statment', 'App\Http\Controllers\AccountStatementController');

 

Route::get('add_order', 'App\Http\Controllers\OrderController@create1');
Route::post('add_order', 'App\Http\Controllers\OrderController@store');

 
Route::get('add_export_order', 'App\Http\Controllers\ExportController@create1');
Route::post('add_export_order', 'App\Http\Controllers\ExportController@store');
//Route::get('/OrderDetails/{id}', 'App\Http\Controllers\OrderController@getDetailsOrder');
Route::get('/OrderDetails/{id}', 'App\Http\Controllers\ProductController@getDetailsOrder');
Route::get('/ExportOrderDetails/{id}', 'App\Http\Controllers\ProductController@getExportDetailsOrder');

Route::get('/productDetails/{id}', 'App\Http\Controllers\ProductController@getproductDetails')->name('productDetails');

Route::get('/export_productDetails/{id}', 'App\Http\Controllers\ProductController@getexport_productDetails')->name('export_productDetails');
Route::get('/export_productDetails_box', 'App\Http\Controllers\ProductController@getexport_productBoxcDetails')->name('export_productDetails_box');
Route::get('/export_product_rechose_product', 'App\Http\Controllers\ProductController@getrechose_product')->name('export_product_rechose_product');
Route::get('/import_order_productDetails1', 'App\Http\Controllers\ProductController@getimport_order_productDetails')->name('import_order_productDetails1');
Route::get('/box_insaid_detailes', 'App\Http\Controllers\BoxController@getBoxDetails')->name('box_insaid_detailes');


Route::resource('companies', 'App\Http\Controllers\ProductCompanyController');


Route::get('/products/{id}', 'App\Http\Controllers\ProductController@getproductsDetaile');
Route::get('/productsgroup/{id}', 'App\Http\Controllers\ProductController@getproductsGruops');
Route::get('/orderProductDeteil/{id}', 'App\Http\Controllers\ProductController@getorderProductDeteil');



Route::resource('import_order', 'App\Http\Controllers\OrderController');
Route::resource('export_order', 'App\Http\Controllers\ExportController');
Route::get('order_file/{id}', 'App\Http\Controllers\ExportController@exporterOrders');

Route::resource('shipmentes', 'App\Http\Controllers\ShipmentController');
Route::get('add_shipment', 'App\Http\Controllers\ShipmentController@create1');
Route::post('/add_shipment1', 'App\Http\Controllers\ShipmentController@store')->name('add_shipment1');
Route::get('/shipmentDeteile/{id}', 'App\Http\Controllers\ShipmentController@getShipmentDeteil');
Route::post('addAttachmentsShipment', 'App\Http\Controllers\ShipmentController@addAttachments')->name('addAttachmentsShipment');
Route::get('download/{orderNumber}/{file_name}', 'App\Http\Controllers\OrderDetailController@get_file');

 Route::get('View_file_sipment/{orderNumber}/{file_name}', 'App\Http\Controllers\ShipmentController@open_file');
 Route::post('delete_file_sipment', 'App\Http\Controllers\ShipmentController@destroy')->name('delete_file_sipment');
 Route::get('download_file_sipment/{orderNumber}/{file_name}', 'App\Http\Controllers\ShipmentController@get_file');
Route::get('/box_order/{id}', 'App\Http\Controllers\ShipmentController@getboxesOrder');
// Route::resource('import_order', 'App\Http\Controllers\OrderController')->except([
//     'show','store','create1'
// ]);

// Route::get('/import_order/{id}', 'App\Http\Controllers\OrderController@index');
Route::resource('invoices', 'App\Http\Controllers\InvoiceController');
Route::get('Invoice_Paid','App\Http\Controllers\InvoiceController@Invoice_Paid')->name('Invoice_Paid');
Route::get('Invoice_UnPaid','App\Http\Controllers\InvoiceController@Invoice_UnPaid')->name('Invoice_UnPaid');
Route::get('Invoice_Partial','App\Http\Controllers\InvoiceController@Invoice_Partial')->name('Invoice_Partial');


Route::get('/{page}', 'App\Http\Controllers\AdminController@index');
Route::get('add_invoices/{category_id}/{order_id}', 'App\Http\Controllers\InvoiceController@createInvoice');


Route::resource('box', 'App\Http\Controllers\BoxController');
Route::post('sharbox', 'App\Http\Controllers\BoxController@create')->name('sharbox');
Route::post('remove_product_fom_order', 'App\Http\Controllers\ProductController@removeProductFomOrder')->name('remove_product_fom_order');
Route::post('rechoce_product_confirm', 'App\Http\Controllers\ProductController@rechoce_product_confirm')->name('rechoce_product_confirm');
Route::post('submit_product', 'App\Http\Controllers\ProductController@submit_product')->name('submit_product');
Route::post('unsubmit_product', 'App\Http\Controllers\ProductController@unsubmit_product')->name('unsubmit_product');
Route::get('show_invoice/{id}','App\Http\Controllers\InvoiceController@show_invoice');
Route::get('all_invoice', 'App\Http\Controllers\InvoiceController@index');
Route::resource('/all_invoice/add', 'App\Http\Controllers\InvoiceController');

Route::get('/Status_show/{id}', 'App\Http\Controllers\InvoiceController@show')->name('Status_show');
Route::post('/Status_Update', 'App\Http\Controllers\InvoiceController@Status_Update')->name('Status_Update');
//
Route::get('/InvoicesDetails/{id}', 'App\Http\Controllers\InvoicesDetailsController@edit');

Route::get('download/{invoice_number}/{file_name}', 'InvoicesDetailsController@get_file');

Route::get('View_file/{invoice_number}/{file_name}', 'InvoicesDetailsController@open_file');

Route::post('delete_file', 'InvoicesDetailsController@destroy')->name('delete_file');

Route::get('/edit_invoice/{id}', 'InvoicesController@edit');




Route::resource('Archive', 'InvoiceAchiveController');







Route::get('export_invoices', 'InvoicesController@export');


