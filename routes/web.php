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


Route::resource('all_product', 'App\Http\Controllers\ProductDetailController');
Route::get('all_machine/{id}', 'App\Http\Controllers\ProductController@index');
Route::resource('all_machine/add_machine', 'App\Http\Controllers\ProductController');
Route::post('addProducts', 'App\Http\Controllers\ProductController@store')->name('addProducts');


 

Route::get('add_order', 'App\Http\Controllers\OrderController@create1');
Route::post('add_order', 'App\Http\Controllers\OrderController@store');


Route::get('add_export_order', 'App\Http\Controllers\ExportController@create1');
Route::post('add_export_order', 'App\Http\Controllers\ExportController@store');
//Route::get('/OrderDetails/{id}', 'App\Http\Controllers\OrderController@getDetailsOrder');
Route::get('/OrderDetails/{id}', 'App\Http\Controllers\ProductController@getDetailsOrder');
Route::get('/productDetails/{id}', 'App\Http\Controllers\ProductController@getproductDetails')->name('productDetails');


Route::resource('companies', 'App\Http\Controllers\ProductCompanyController');


Route::get('/products/{id}', 'App\Http\Controllers\ProductController@getproductsDetaile');
Route::get('/productsgroup/{id}', 'App\Http\Controllers\ProductController@getproductsGruops');
Route::get('/orderProductDeteil/{id}', 'App\Http\Controllers\ProductController@getorderProductDeteil');



Route::resource('import_order', 'App\Http\Controllers\OrderController');
Route::resource('export_order', 'App\Http\Controllers\ExportController');

// Route::resource('import_order', 'App\Http\Controllers\OrderController')->except([
//     'show','store','create1'
// ]);

// Route::get('/import_order/{id}', 'App\Http\Controllers\OrderController@index');

Route::get('/{page}', 'App\Http\Controllers\AdminController@index');






