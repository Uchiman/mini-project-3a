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
Route::get('staff/pengeluaran/data', 'DataController@pengeluaran')->name('pengeluaran.data');
Route::get('kasir/member/data', 'DataController@member')->name('member.data');
Route::get('pimpinan/stok-bulan/data', 'DataController@stokBulan')->name('stokBulan.data');
Route::get('pimpinan/stok-hari/data', 'DataController@stokBulan')->name('stokHari.data');
Route::get('pimpinan/laporan-bulan/data', 'DataController@dataBulan')->name('dataBulan.data');

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['role:staff']], function () {
    // home
    Route::get('/staff', 'HomeController@staff')->name('staff');
    // crud data
    Route::resource('staff/barang', 'BarangController');
    Route::resource('staff/pembelian', 'PembelianController');
    Route::resource('staff/supplier', 'SupplierController');
    Route::resource('staff/kategori', 'KategoriController');
    Route::resource('staff/pengeluaran', 'PengeluaranController');
});


Route::group(['middleware' => ['role:kasir']], function () {
    // home
    Route::get('/kasir', 'HomeController@kasir')->name('kasir');
    // transaksi penjualan
    Route::get('/kasir/penjualan/hasil', 'PenjualanController@hasil')->name('kasir.hasil');
    Route::resource('kasir/penjualan', 'PenjualanController');
    Route::post('/kasir', 'PenjualanController@inputBarang')->name('kasir.store');
    Route::post('/kasir2', 'PenjualanController@hasilPenjualan')->name('kasir2.store');
    // member
    Route::resource('kasir/member', 'MemberController');
});


Route::group(['middleware' => ['role:pimpinan']], function () {
    // home
    // laporan stok
    Route::get('/pimpinan/stok/bulan', 'LaporanController@stokBulan')->name('pimpinan.stokBulan');
    Route::get('/pimpinan/stok/hari', 'LaporanController@stokHari')->name('pimpinan.stokHari');
    Route::get('/pimpinan/laporan/bulan', 'LaporanController@dataBulan')->name('pimpinan.dataBulan');
    Route::get('/pimpinan/laporan/bulan/{bulan}', 'LaporanController@detailBulan')->name('pimpinan.detailBulan');
});