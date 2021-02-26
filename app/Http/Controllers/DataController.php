<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Kategori;
use App\Member;
use App\Pembelian;
use App\Pengeluaran;
use App\Supplier;
use Illuminate\Http\Request;

class DataController extends Controller
{
    // data barang
    public function barang()
    {
        $barang = Barang::with('kategori')->get();

        return datatables()->of($barang)
            ->addColumn('action', 'staff.barang.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    // transaksi pembelian
    public function pembelian()
    {
        $pembelian = Pembelian::all();

        return datatables()->of($pembelian)
            ->addColumn('action', 'staff.pembelian.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    // supplier
    public function supplier()
    {
        $supplier = Supplier::all();

        return datatables()->of($supplier)
            ->addColumn('action', 'staff.supplier.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    // kategori
    public function kategori()
    {
        $kategori = Kategori::all();

        return datatables()->of($kategori)
            ->addColumn('action', 'staff.kategori.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    // pengeluaran
    public function pengeluaran()
    {
        $pengeluaran = Pengeluaran::all();

        return datatables()->of($pengeluaran)
            ->addColumn('action', 'staff.pengeluaran.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    // member
    public function member()
    {
        $member = Member::all();

        return datatables()->of($member)
            ->addColumn('action', 'kasir.member.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }
}
