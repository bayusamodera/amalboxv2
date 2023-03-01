<?php

use App\Http\Controllers\ConsumeApiController;

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

Route::get('/', 'LandingPageController@index')->name('landingpage');
Route::get('/about', 'LandingPageController@about')->name('about');


Route::resources([
    'program' => 'ProgramController',
]);
Route::get('/program/create', 'ProgramController@create')->name('program.create');
Route::get('/invoice','InvoiceController@index')->name('invoice.index');
Route::get('/konfirmasi/{id}','InvoiceController@konfirmasi')->name('invoice.konfirmasi');
Route::get('/program/destroy/{id}','ProgramController@destroy')->name('program.destroy');
Route::get('/program/edit/{id}','ProgramController@edit')->name('program.edit');
Route::post('/program/update/{id}','ProgramController@update')->name('program.update');
Route::get('/program/donasi/{id}','ProgramController@donasi')->name('program.donasi');

Route::get('/program/publish/{id}','ProgramController@publish')->name('program.publish');

Route::get('/program/unpublish/{id}','ProgramController@unpublish')->name('program.unpublish');

Route::get('/programinfo/{id}','ProgramInfoController@index')->name('programinfo.index');
Route::get('/programinfo/{id}/create','ProgramInfoController@create')->name('programinfo.create');
Route::post('/programinfo/{id}/store','ProgramInfoController@store')->name('programinfo.store');

Auth::routes();

Route::group(['prefix'=>'adm','middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
   
});

Route::get('/program/show/{id}', 'ProgramController@show')->name('umum.program.show');
Route::get('/program/amal/{id}', 'ProgramController@amal')->name('umum.program.amal');
Route::post('/programdonatur', 'ProgramDonaturController@store')->name('umum.donatur.store');
Route::get('/programdonatur/{id}', 'ProgramDonaturController@show')->name('umum.donatur.show');

Route::get('/kalkulatorzakat', 'KalkulatorZakatController@index')->name('umum.kalkulatorzakat');

Route::post('/kalkulatorzakat/tambahzakat', 'KalkulatorZakatController@tambahzakat')->name('umum.tambahzakat');
Route::get('/kalkulatorzakat/semuazakat', 'KalkulatorZakatController@semuazakat')->name('umum.semuazakat');
Route::post('/cart/tambahprogram', 'CartController@tambahprogram')->name('umum.tambahprogram');

Route::get('/cart/destroy/{id}','CartController@destroy')->name('umum.destroyprogram');

Route::get('/cart','CartController@show')->name('umum.cart.show');
Route::get('/pembayaran','CartController@pembayaran')->name('umum.cart.pembayaran');
Route::post('/pembayaran','InvoiceController@store')->name('umum.invoice.store');
Route::get('/invoice/{id}/{token}','InvoiceController@show')->name('umum.invoice.show');
Route::post('/invoice/{id}/{token}/bukti','InvoiceController@uploadbukti')->name('umum.invoice.uploadbukti');
Route::get('/invoice/{id}/{token}/cek','InvoiceController@cek')->name('umum.invoice.cek');

Route::get('/zakat', 'ProgramController@zakatall')->name('umum.program.zakatall');
Route::get('/amal', 'ProgramController@amalall')->name('umum.program.amalall');

Route::get('/snaptoken','SnapController@token')->name('midtrans.snap');

route::get('/brawrawrb',function() {
    return Artisan::call('migrate');
});

Route::get('/aramoroia', 'ConsumeApiController@cektransfer');

Route::post('/salurkanotomatis', 'ProgramController@salurkanotomatis')->name('umum.salurkanotomatis');

Route::get('/mailable', function () {
    $invoice = App\Models\Invoice::find(42);

    return new App\Mail\InvoiceSelesaiMail($invoice);
});