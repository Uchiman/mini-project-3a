<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// user
Route::post('register', 'API\UserController@register');
Route::post('login', 'API\UserController@login');
Route::post('logout', 'API\UserController@logout');
Route::get('info', 'API\UserController@getAuthenticatedUser');

Route::post('kirim-email', 'API\EmailController@sendEmail')->middleware('jwt.verify');
Route::post('verify-email', 'API\EmailController@verifyEmail')->middleware('jwt.verify');

// kasir
Route::group(['middleware' => ['jwt.verify']], function () {
    // registrasi member
    Route::post('register-member', 'API\MemberController@registerMember');
    // penjualan
    Route::post('kasir', 'API\KasirController@detailPenjualan');
    Route::post('kasir2', 'API\KasirController@hasilPenjualan');
    Route::get('kuitansi1', 'API\KasirController@kuitansi1');
    Route::get('kuitansi2', 'API\KasirController@kuitansi2');
    Route::get('kuitansi3', 'API\KasirController@kuitansi3');
    Route::put('kasir/{id}', 'API\KasirController@updateData');
    Route::delete('kasir/{id}', 'API\KasirController@destroyData');
    // absen
    Route::post('absen', 'API\KasirController@absen');
    Route::get('absen-status', 'API\KasirController@dataAbsen');
});


// pimpinan
Route::group(['middleware' => ['jwt.verify']], function () {
    // laporan
    Route::get('laporan', 'API\PimpinanController@dataBulan');
    Route::get('laporan-hari/{bulan}', 'API\PimpinanController@dataHari');
    Route::get('laporan/{bulan}', 'API\PimpinanController@laporanPimpinan');
    // laporan stok barang
    Route::get('laporan-stok/{bulan}', 'API\PimpinanController@stokBarangPerBulan');
    // laporan pembelian barang
    Route::get('laporan-pembelian/{bulan}', 'API\PimpinanController@dataPembelianPerBulan');
    // laporan penjualan barang
    Route::get('laporan-penjualan/{bulan}', 'API\PimpinanController@dataPenjualanPerBulan');
    Route::get('laporan-penjualan-detail/{id}', 'API\PimpinanController@detailPenjualan');
    // pengeluaran
    Route::get('pengeluaran', 'API\PimpinanController@semuaPengeluaran');
    Route::post('input-pengeluaran', 'API\PimpinanController@inputPengeluaran');
    Route::put('input-pengeluaran/{id}', 'API\PimpinanController@updatePengeluaran');
    Route::delete('input-pengeluaran/{id}', 'API\PimpinanController@deletePengeluaran');
    // supplier
    Route::get('supplier', 'API\PimpinanController@semuaSupplier');
    Route::post('input-supplier', 'API\PimpinanController@inputSupplier');
    Route::put('input-supplier/{id}', 'API\PimpinanController@updateSupplier');
    Route::delete('input-supplier/{id}', 'API\PimpinanController@deleteSupplier');
    // kategori
    Route::get('kategori', 'API\PimpinanController@semuaKategori');
    Route::post('input-kategori', 'API\PimpinanController@inputKategori');
    Route::put('input-kategori/{id}', 'API\PimpinanController@updateKategori');
    Route::delete('input-kategori/{id}', 'API\PimpinanController@deleteKategori');
    // laporan laba rugi
    Route::get('laporan-laba/{hari}', 'API\PimpinanController@laporanLabaRugi');
    // kode absen
    Route::post('kode-absen', 'API\PimpinanController@kodeAbsen');
    Route::get('kode-absen', 'API\PimpinanController@kodeAbsenHarian');

});


// staff
Route::group(['middleware' => ['jwt.verify']], function () {
    // CRUD data barang
    Route::get('data-barang', 'API\StaffController@dataBarang');
    Route::post('input-data-barang', 'API\StaffController@inputBarang');
    Route::put('input-data-barang/{id}', 'API\StaffController@updateBarang');
    Route::delete('input-data-barang/{id}', 'API\StaffController@deleteBarang');
    // CRUD data pembelian
    Route::get('data-pembelian', 'API\StaffController@dataPembelian');
    Route::post('input-pembelian-barang', 'API\StaffController@pembelianBarang');
    Route::put('input-pembelian-barang/{id}', 'API\StaffController@updatePembelian');
    Route::delete('input-pembelian-barang/{id}', 'API\StaffController@deletePembelian');
    // lain-lain
    Route::get('kategori-barang', 'API\StaffController@kategoriBarang');
    Route::get('kategori-barang/{id}', 'API\StaffController@barangPerKategori');
    Route::get('tanggal-pembelian', 'API\StaffController@tanggalPembelian');
    Route::get('tanggal-pembelian/{tanggal}', 'API\StaffController@pembelianPerTanggal');
});

// member
Route::post('login-member', 'API\MemberController@loginMember');
