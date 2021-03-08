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
Route::get('pimpinan/stok-hari/data', 'DataController@stokHari')->name('stokHari.data');
Route::get('pimpinan/laporan-bulan/data', 'DataController@dataBulan')->name('dataBulan.data');
Route::get('pimpinan/laporan-hari/data', 'DataController@dataHari')->name('dataHari.data');
Route::get('admin/users/data', 'DataController@users')->name('users.data');

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::group(['middleware' => ['role:staff|kasir|pimpinan|admin']], function () {
    // home
    Route::get('/home', 'HomeController@index')->name('home');
    // vertifikasi akun
    Route::get('/akun/vertifikasi', 'UserController@viewEmail')->name('akun.vertifikasi');
    Route::post('/akun/vertifikasi', 'UserController@sendMail')->name('akun.kirim-vertifikasi');
    Route::post('/akun/vertifikasi-email', 'UserController@verifyEmail')->name('akun.vertifikasi-email');
    Route::resource('/akun', 'UserController');
});

Route::group(['middleware' => ['role:admin']], function () {
    // home
    Route::get('/admin', 'HomeController@admin')->name('admin');
    // crud data
    Route::resource('admin/users', 'UsersController');
});

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
    Route::get('/pimpinan', 'HomeController@pimpinan')->name('pimpinan');
    // laporan stok
    Route::get('/pimpinan/stok/bulan', 'LaporanController@stokBulan')->name('pimpinan.stokBulan');
    Route::get('/pimpinan/stok/hari', 'LaporanController@stokHari')->name('pimpinan.stokHari');
    // laporan bulan
    Route::get('/pimpinan/laporan/bulan', 'LaporanController@dataBulan')->name('pimpinan.dataBulan');
    Route::get('/pimpinan/laporan/bulan/{bulan}', 'LaporanController@detailBulan')->name('pimpinan.detailBulan');
    Route::get('/pimpinan/laporan/bulan-ini', 'LaporanController@detailBulan2')->name('pimpinan.detailBulan2');
    Route::get('/pimpinan/laporan/bulan/pembelian/{bulan}', 'LaporanController@pembelianBulan')->name('pimpinan.pembelianBulan');
    Route::get('/pimpinan/laporan/bulan/penjualan/{bulan}', 'LaporanController@penjualanBulan')->name('pimpinan.penjualanBulan');
    Route::get('/pimpinan/laporan/bulan/penjualan/detail/{id}', 'LaporanController@detailPenjualan')->name('pimpinan.detailPenjualan');
    Route::get('/pimpinan/laporan/bulan/pengeluaran/{bulan}', 'LaporanController@pengeluaranBulan')->name('pimpinan.pengeluaranBulan');
    Route::get('/pimpinan/laporan/bulan/absensi/{bulan}', 'LaporanController@absensiBulan')->name('pimpinan.absensiBulan');
    // laporan hari
    Route::get('/pimpinan/laporan/hari', 'LaporanController@dataHari')->name('pimpinan.dataHari');
    Route::get('/pimpinan/laporan/hari/{hari}', 'LaporanController@detailHari')->name('pimpinan.detailHari');
    Route::get('/pimpinan/laporan/hari-ini', 'LaporanController@detailHari2')->name('pimpinan.detailHari2');
    Route::get('/pimpinan/laporan/hari/penjualan/{hari}', 'LaporanController@penjualanHari')->name('pimpinan.penjualanHari');
    Route::get('/pimpinan/laporan/hari/penjualan/detail/{id}', 'LaporanController@detailPenjualan')->name('pimpinan.detailPenjualan2');
    // absensi kasir
    Route::get('/pimpinan/absen', 'LaporanController@absen')->name('pimpinan.absen');
    Route::post('/pimpinan/absen', 'LaporanController@kodeAbsen')->name('pimpinan.kode-absen');

});