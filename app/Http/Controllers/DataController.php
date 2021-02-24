<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Kategori;
use App\Pembelian;
use App\Supplier;
use Illuminate\Http\Request;

class DataController extends Controller
{
    // data barang
    public function barang()
    {
        $barang = Barang::with('kategori')->orderBy('nama', 'ASC');

        return datatables()->of($barang)
        ->addColumn('action', 'staff.barang.action')
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
    }

    // transaksi pembelian
    public function pembelian()
    {
        $pembelian = Pembelian::orderBy('supplier', 'ASC');

        return datatables()->of($pembelian)
        ->addColumn('action', 'staff.pembelian.action')
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
    }

    // supplier
    public function supplier()
    {
        $supplier = Supplier::orderBy('nama', 'ASC');

        return datatables()->of($supplier)
        ->addColumn('action', 'staff.supplier.action')
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
    }

    // kategori
    public function kategori()
    {
        $kategori = Kategori::orderBy('nama', 'ASC');

        return datatables()->of($kategori)
        ->addColumn('action', 'staff.kategori.action')
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
    }
}
