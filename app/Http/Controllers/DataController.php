<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Kategori;
use App\LaporanStok;
use App\Member;
use App\Pembelian;
use App\Pengeluaran;
use App\Penjualan;
use App\Supplier;
use App\User;
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

    // laporan stok bulanan
    public function stokBulan()
    {
        $stokBarang = LaporanStok::with('barang')->get();

        $res  = [];
        foreach ($stokBarang as $vals) {
            if (array_key_exists($vals['barang_id'], $res)) {
                $res[$vals['barang_id']]['barang_masuk']    += $vals['barang_masuk'];
                $res[$vals['barang_id']]['terjual']   += $vals['terjual'];
                $res[$vals['barang_id']]['barang_id']        = $vals['barang_id'];
            } else {
                $res[$vals['barang_id']]  = $vals;
            }
        }

        return datatables()->of($res)
            ->addIndexColumn()
            ->toJson();
    }

    // laporan stok harian
    public function stokHari()
    {
        $stokBarang = LaporanStok::with('barang')->get();

        return datatables()->of($stokBarang)
            ->addIndexColumn()
            ->toJson();
    }

    // laporan bulanan
    public function dataBulan()
    {
        $bulan = LaporanStok::all()->unique('bulan');

        return datatables()->of($bulan)
            ->addColumn('action', 'pimpinan.laporan.bulan.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    // laporan harian
    public function dataHari()
    {
        $hari = LaporanStok::all()->unique('hari');

        return datatables()->of($hari)
            ->addColumn('action', 'pimpinan.laporan.hari.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    // data semua user
    public function users()
    {
        $user = User::role(['staff', 'pimpinan', 'kasir'])->with('roles')->get();

        return datatables()->of($user)
            ->addColumn('action', 'admin.users.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }
}
