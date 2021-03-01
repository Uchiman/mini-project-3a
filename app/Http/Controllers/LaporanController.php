<?php

namespace App\Http\Controllers;

use App\LabaRugi;
use App\Pembelian;
use App\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // stok barang per bulan
    public function stokBulan()
    {
        $user = Auth::user();
        return view('pimpinan.stok.bulan', compact('user'));
    }

    // stok barang per hari
    public function stokHari()
    {
        $user = Auth::user();
        return view('pimpinan.stok.hari', compact('user'));
    }

    // data bulan
    public function dataBulan()
    {
        $user = Auth::user();
        return view('pimpinan.laporan.bulan', compact('user'));
    }

    // data detail bulan
    public function detailBulan($bulan)
    {
        $user = Auth::user(); 

        $pembelian = Pembelian::where('bulan', $bulan)->get()->count();
        $penjualan = Penjualan::where('bulan', $bulan)->get()->count();
        $namaBulan = LabaRugi::where('bulan', $bulan)->first();

        $pemasukan = LabaRugi::where('bulan', $bulan)->get()->sum('total_pemasukan');
        $pengeluaran = LabaRugi::where('bulan', $bulan)->get()->sum('total_pengeluaran');
        $labaRugi = LabaRugi::where('bulan', $bulan)->get()->sum('hasil');

        $data = [];
        $data = [
            'pembelian' => $pembelian,
            'penjualan' => $penjualan,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'labaRugi' => $labaRugi,
        ];

        return view('pimpinan.laporan.detail_bulan', compact('user', 'data', 'namaBulan'));
    }
}
