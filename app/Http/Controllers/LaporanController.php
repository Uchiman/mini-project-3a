<?php

namespace App\Http\Controllers;

use App\Absen;
use App\Barang;
use App\DetailPenjualan;
use App\KodeAbsen;
use App\LabaRugi;
use App\Pembelian;
use App\Pengeluaran;
use App\Penjualan;
use App\User;
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
        return view('pimpinan.laporan.bulan.bulan', compact('user'));
    }

    // data detail bulan
    public function detailBulan($bulan)
    {
        $user = Auth::user();

        $pembelian = Pembelian::where('bulan', $bulan)->get()->count();
        $penjualan = Penjualan::where('bulan', $bulan)->get()->count();
        $pengeluaran2 = Pengeluaran::where('bulan', $bulan)->get()->count();
        $namaBulan = LabaRugi::where('bulan', $bulan)->first();
        $kasir = User::role('kasir')->get()->count();
        $karyawan = User::role(['kasir', 'staff'])->get()->count();

        $pemasukan = LabaRugi::where('bulan', $bulan)->get()->sum('total_pemasukan');
        $pengeluaran = LabaRugi::where('bulan', $bulan)->get()->sum('total_pengeluaran');
        $labaRugi = LabaRugi::where('bulan', $bulan)->get()->sum('hasil');

        $data = [];
        $data = [
            'pembelian' => $pembelian,
            'penjualan' => $penjualan,
            'pengeluaran2' => $pengeluaran2,
            'karyawan' => $karyawan,
            'kasir' => $kasir,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'labaRugi' => $labaRugi,
        ];

        return view('pimpinan.laporan.bulan.detail', compact('user', 'data', 'namaBulan'));
    }

    // pembelian per bulan
    public function pembelianBulan($bulan)
    {
        $user = Auth::user();
        $pembelians = Pembelian::where('bulan', $bulan)->get();
        return view('pimpinan.laporan.bulan.pembelian', compact('user', 'pembelians'));
    }

    // pengeluaran per bulan
    public function pengeluaranBulan($bulan)
    {
        $user = Auth::user();
        $pengeluarans = Pengeluaran::where('bulan', $bulan)->get();
        return view('pimpinan.laporan.bulan.pengeluaran', compact('user', 'pengeluarans'));
    }

    // absensi per bulan
    public function absensiBulan($bulan)
    {
        $user = Auth::user();
        $date = explode('-', $bulan);
        $year = $date[0];
        $month = $date[1];
        $dataAbsen = KodeAbsen::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $totalAbsen = count($dataAbsen);
        $absensi = Absen::whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
        $absen  = [];
        foreach ($absensi as $vals) {
            if (array_key_exists($vals['user_id'], $absen)) {
                $absen[$vals['user_id']]['absen']    += $vals['absen'];
            } else {
                $absen[$vals['user_id']]  = $absen;
            }
        }
        return view('pimpinan.laporan.bulan.absensi', compact('user', 'absensi', 'totalAbsen'));
    }


    // pembelian per bulan
    public function penjualanBulan($bulan)
    {
        $user = Auth::user();
        $penjualans = Penjualan::where('bulan', $bulan)->with('kasir')->get();

        return view('pimpinan.laporan.bulan.penjualan', compact('user', 'penjualans'));
    }

    // pembelian per bulan
    public function detailPenjualan($id)
    {
        $user = Auth::user();
        $penjualan = Penjualan::latest()->first();
        $detail_penjualans = DetailPenjualan::where('penjualan_id', $id)->get();
        $kasir = User::where('id', $penjualan->kasir_id)->first();

        return view('pimpinan.laporan.bulan.detail_penjualan', compact('user', 'detail_penjualans', 'penjualan', 'kasir'));
    }

    // data hari
    public function dataHari()
    {
        $user = Auth::user();
        return view('pimpinan.laporan.hari.hari', compact('user'));
    }

    // data detail hari
    public function detailHari($hari)
    {
        $user = Auth::user();


        $namaHari = LabaRugi::where('hari', $hari)->first();
        $labaRugi = LabaRugi::where('hari', $hari)->first();

        $jumlah_barang = DetailPenjualan::whereDate('created_at', $hari)->sum('jumlah_barang');
        $pendapatan = $labaRugi->total_pemasukan;
        $detail_barang = DetailPenjualan::whereDate('created_at', $hari)->get();

        foreach ($detail_barang as $barang) {
            $barangDB = Barang::where('id', $barang->barang_id)->first();
            $keuntunganarr[] = $barang->jumlah_barang * ($barangDB->harga_jual - $barangDB->harga_beli);
            $keuntungan = array_sum($keuntunganarr);
            $data = [];
            if ($keuntunganarr) {
                $keuntungan = array_sum($keuntunganarr);
                $data = [
                    'jumlah_penjualan'  => $jumlah_barang,
                    'pendapatan'        => number_format($pendapatan, 0, ',', '.'),
                    'keuntungan'        => number_format($keuntungan, 0, ',', '.'),
                ];
                return view('pimpinan.laporan.hari.detail', compact('user', 'data', 'namaHari'));
            }
        }
        $keuntungan  = 0;
        $data = [
            'jumlah_penjualan'  => $jumlah_barang,
            'pendapatan'        => number_format($pendapatan, 0, ',', '.'),
            'keuntungan'        => number_format($keuntungan, 0, ',', '.'),
        ];
        return view('pimpinan.laporan.hari.detail', compact('user', 'data', 'namaHari'));
    }
}
