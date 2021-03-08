<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Welcome', route('home'));
});

// Akun Index
Breadcrumbs::for('akun.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Info Akun', route('akun.index'));
});

// Akun Edit
Breadcrumbs::for('akun.edit', function ($trail, $data) {
    $trail->push('Home', route('home'));
    $trail->push('Info Akun', route('akun.index'));
    $trail->push('Edit Akun', route('akun.edit', $data));
});

// Akun Vertifikasi
Breadcrumbs::for('akun.vertifikasi', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Info Akun', route('akun.index'));
    $trail->push('Vertifikasi Akun', route('akun.vertifikasi'));
});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/


// Index Users
Breadcrumbs::for('users.index', function ($trail) {
    $trail->push('Home', route('admin'));
    $trail->push('Users', route('users.index'));
});


// Create Users
Breadcrumbs::for('users.create', function ($trail) {
    $trail->push('Home', route('admin'));
    $trail->push('Users', route('users.index'));
    $trail->push('Tambah Users', route('users.create'));
});

// Edit Users
Breadcrumbs::for('users.edit', function ($trail, $users) {
    $trail->push('Home', route('admin'));
    $trail->push('Users', route('users.index'));
    $trail->push('Edit Users', route('users.edit', $users));
});


/*
|--------------------------------------------------------------------------
| STAFF
|--------------------------------------------------------------------------
*/

// Home
Breadcrumbs::for('staff', function ($trail) {
    $trail->push('Home', route('staff'));
});

// Index Barang
Breadcrumbs::for('barang.index', function ($trail) {
    $trail->push('Home', route('staff'));
    $trail->push('Barang', route('barang.index'));
});

// Create Barang
Breadcrumbs::for('barang.create', function ($trail) {
    $trail->push('Home', route('staff'));
    $trail->push('Barang', route('barang.index'));
    $trail->push('Tambah Barang', route('barang.create'));
});

// Edit Barang
Breadcrumbs::for('barang.edit', function ($trail, $barang) {
    $trail->push('Home', route('staff'));
    $trail->push('Barang', route('barang.index'));
    $trail->push('Edit Barang', route('barang.edit', $barang));
});

// Index Pembelian
Breadcrumbs::for('pembelian.index', function ($trail) {
    $trail->push('Home', route('staff'));
    $trail->push('Pembelian', route('pembelian.index'));
});

// Create Pembelian
Breadcrumbs::for('pembelian.create', function ($trail) {
    $trail->push('Home', route('staff'));
    $trail->push('Pembelian', route('pembelian.index'));
    $trail->push('Tambah Pembelian', route('pembelian.create'));
});

// Edit Pembelian
Breadcrumbs::for('pembelian.edit', function ($trail, $barang) {
    $trail->push('Home', route('staff'));
    $trail->push('Pembelian', route('pembelian.index'));
    $trail->push('Edit Pembelian', route('pembelian.edit', $barang));
});

// Index Supplier
Breadcrumbs::for('supplier.index', function ($trail) {
    $trail->push('Home', route('staff'));
    $trail->push('Supplier', route('supplier.index'));
});

// Create Supplier
Breadcrumbs::for('supplier.create', function ($trail) {
    $trail->push('Home', route('staff'));
    $trail->push('Supplier', route('supplier.index'));
    $trail->push('Tambah Supplier', route('supplier.create'));
});

// Edit Supplier
Breadcrumbs::for('supplier.edit', function ($trail, $barang) {
    $trail->push('Home', route('staff'));
    $trail->push('Supplier', route('supplier.index'));
    $trail->push('Edit Supplier', route('supplier.edit', $barang));
});

// Index Kategori
Breadcrumbs::for('kategori.index', function ($trail) {
    $trail->push('Home', route('staff'));
    $trail->push('Kategori', route('kategori.index'));
});

// Create Kategori
Breadcrumbs::for('kategori.create', function ($trail) {
    $trail->push('Home', route('staff'));
    $trail->push('Kategori', route('kategori.index'));
    $trail->push('Tambah Kategori', route('kategori.create'));
});

// Edit Kategori
Breadcrumbs::for('kategori.edit', function ($trail, $barang) {
    $trail->push('Home', route('staff'));
    $trail->push('Kategori', route('kategori.index'));
    $trail->push('Edit Kategori', route('kategori.edit', $barang));
});

// Index Pengeluaran
Breadcrumbs::for('pengeluaran.index', function ($trail) {
    $trail->push('Home', route('staff'));
    $trail->push('Pengeluaran', route('pengeluaran.index'));
});

// Create Pengeluaran
Breadcrumbs::for('pengeluaran.create', function ($trail) {
    $trail->push('Home', route('staff'));
    $trail->push('Pengeluaran', route('pengeluaran.index'));
    $trail->push('Tambah Pengeluaran', route('pengeluaran.create'));
});

// Edit Pengeluaran
Breadcrumbs::for('pengeluaran.edit', function ($trail, $barang) {
    $trail->push('Home', route('staff'));
    $trail->push('Pengeluaran', route('pengeluaran.index'));
    $trail->push('Edit Pengeluaran', route('pengeluaran.edit', $barang));
});

/*
|--------------------------------------------------------------------------
| KASIR
|--------------------------------------------------------------------------
*/

// Home
Breadcrumbs::for('kasir', function ($trail) {
    $trail->push('Home', route('kasir'));
});

// Index Penjualan
Breadcrumbs::for('penjualan.index', function ($trail) {
    $trail->push('Home', route('kasir'));
    $trail->push('Penjualan', route('penjualan.index'));
});

// Edit Penjualan
Breadcrumbs::for('penjualan.edit', function ($trail, $barang) {
    $trail->push('Home', route('kasir'));
    $trail->push('Penjualan', route('penjualan.index'));
    $trail->push('Edit Barang', route('penjualan.edit', $barang));
});

// Hasil Penjualan (Kuitansi)
Breadcrumbs::for('kasir.hasil', function ($trail) {
    $trail->push('Home', route('kasir'));
    $trail->push('Penjualan', route('penjualan.index'));
    $trail->push('Hasil', route('kasir.hasil'));
});

// Index Member
Breadcrumbs::for('member.index', function ($trail) {
    $trail->push('Home', route('kasir'));
    $trail->push('Member', route('member.index'));
});

// Create Member
Breadcrumbs::for('member.create', function ($trail) {
    $trail->push('Home', route('kasir'));
    $trail->push('Member', route('member.index'));
    $trail->push('Tambah Member', route('member.create'));
});

// Edit Member
Breadcrumbs::for('member.edit', function ($trail, $barang) {
    $trail->push('Home', route('kasir'));
    $trail->push('Member', route('member.index'));
    $trail->push('Edit Member', route('member.edit', $barang));
});

/*
|--------------------------------------------------------------------------
| PIMPINAN
|--------------------------------------------------------------------------
*/

// Home
Breadcrumbs::for('pimpinan', function ($trail) {
    $trail->push('Home', route('pimpinan'));
});

// Index Laporan Bulanan
Breadcrumbs::for('pimpinan.dataBulan', function ($trail) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Data Bulan', route('pimpinan.dataBulan'));
});

// Detail Laporan Bulanan
Breadcrumbs::for('pimpinan.detailBulan', function ($trail, $data) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Data Bulan', route('pimpinan.dataBulan'));
    $trail->push('Laporan Bulanan', route('pimpinan.detailBulan', $data));
});


// Detail Laporan Bulanan 2
Breadcrumbs::for('pimpinan.detailBulan2', function ($trail) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Laporan Bulanan', route('pimpinan.detailBulan2'));
});

// Laporan Pembelian Bulanan 
Breadcrumbs::for('pimpinan.pembelianBulan', function ($trail, $data) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Data Bulan', route('pimpinan.dataBulan'));
    $trail->push('Laporan Bulanan', route('pimpinan.detailBulan', $data));
    $trail->push('Pembelian', route('pimpinan.pembelianBulan', $data));
});

// Laporan Penjualan Bulanan 
Breadcrumbs::for('pimpinan.penjualanBulan', function ($trail, $data) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Data Bulan', route('pimpinan.dataBulan'));
    $trail->push('Laporan Bulanan', route('pimpinan.detailBulan', $data));
    $trail->push('Pembelian', route('pimpinan.penjualanBulan', $data));
});

// Laporan Detail Penjualan Bulanan 
Breadcrumbs::for('pimpinan.detailPenjualan', function ($trail, $data) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Data Bulan', route('pimpinan.dataBulan'));
    $trail->push('Laporan Bulanan', route('pimpinan.detailBulan', $data));
    $trail->push('Pembelian', route('pimpinan.penjualanBulan', $data));
    $trail->push('Detail', route('pimpinan.detailPenjualan', $data));
});

// Laporan Pengeluaran Bulanan 
Breadcrumbs::for('pimpinan.pengeluaranBulan', function ($trail, $data) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Data Bulan', route('pimpinan.dataBulan'));
    $trail->push('Laporan Bulanan', route('pimpinan.detailBulan', $data));
    $trail->push('Pembelian', route('pimpinan.pengeluaranBulan', $data));
});

// Laporan Absensi Bulanan 
Breadcrumbs::for('pimpinan.absensiBulan', function ($trail, $data) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Data Bulan', route('pimpinan.dataBulan'));
    $trail->push('Laporan Bulanan', route('pimpinan.detailBulan', $data));
    $trail->push('Pembelian', route('pimpinan.absensiBulan', $data));
});

// Index Laporan Harian
Breadcrumbs::for('pimpinan.dataHari', function ($trail) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Data Hari', route('pimpinan.dataHari'));
});

// Detail Laporan Harian
Breadcrumbs::for('pimpinan.detailHari', function ($trail, $data) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Data Hari', route('pimpinan.dataHari'));
    $trail->push('Laporan Harian', route('pimpinan.detailHari', $data));
});

// Detail Laporan Harian 2
Breadcrumbs::for('pimpinan.detailHari2', function ($trail) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Laporan Harian', route('pimpinan.detailHari2'));
});

// Laporan Penjualan Harian 
Breadcrumbs::for('pimpinan.penjualanHari', function ($trail, $data) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Data Hari', route('pimpinan.dataHari'));
    $trail->push('Laporan Harian', route('pimpinan.detailHari', $data));
    $trail->push('Pembelian', route('pimpinan.penjualanHari', $data));
});

// Laporan Detail Penjualan Harian 
Breadcrumbs::for('pimpinan.detailPenjualan2', function ($trail, $data) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Data Hari', route('pimpinan.dataHari'));
    $trail->push('Laporan Harian', route('pimpinan.detailHari', $data));
    $trail->push('Pembelian', route('pimpinan.penjualanHari', $data));
    $trail->push('Detail', route('pimpinan.detailPenjualan2', $data));
});

// Laporan Stok Harian
Breadcrumbs::for('pimpinan.stokHari', function ($trail) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Laporan Harian', route('pimpinan.stokHari'));
});

// Laporan Stok Bulanan
Breadcrumbs::for('pimpinan.stokBulan', function ($trail) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Laporan Harian', route('pimpinan.stokBulan'));
});

// Absensi Kasir
Breadcrumbs::for('pimpinan.absen', function ($trail) {
    $trail->push('Home', route('pimpinan'));
    $trail->push('Absensi Kasir', route('pimpinan.absen'));
});
