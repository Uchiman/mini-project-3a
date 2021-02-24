<?php

use Illuminate\Support\Facades\Route;

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

// datatable
Route::get('staff/barang/data', 'DataController@barang')->name('barang.data');
Route::get('staff/pembelian/data', 'DataController@pembelian')->name('pembelian.data');
Route::get('staff/supplier/data', 'DataController@supplier')->name('supplier.data');
Route::get('staff/kategori/data', 'DataController@kategori')->name('kategori.data');

Route::resource('staff/barang', 'BarangController');
Route::resource('staff/pembelian', 'PembelianController');
Route::resource('staff/supplier', 'SupplierController');
Route::resource('staff/kategori', 'KategoriController');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');