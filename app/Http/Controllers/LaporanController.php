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
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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


    // penjualan per bulan
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
        $penjualan = Penjualan::find($id);
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
        $penjualan = Penjualan::where('hari', $hari)->get()->count();
        $labaRugi = LabaRugi::where('hari', $hari)->first();
        $jumlah_barang = DetailPenjualan::whereDate('created_at', $hari)->sum('jumlah_barang');
        $pendapatan = $labaRugi->total_pemasukan;
        $detail_barang = DetailPenjualan::whereDate('created_at', $hari)->get();
        foreach ($detail_barang as $barang) {
            $barangDB = Barang::where('id', $barang->barang_id)->first();
            $keuntunganarr[] = $barang->jumlah_barang * ($barangDB->harga_jual - $barangDB->harga_beli);
            $keuntungan = array_sum($keuntunganarr);
            if ($keuntunganarr) {
                $keuntungan = array_sum($keuntunganarr);
            } else {
                $keuntungan  = 0;
            }
        }

        $data = [
            'penjualan'         => $penjualan,
            'jumlah_penjualan'  => $jumlah_barang,
            'pendapatan'        => number_format($pendapatan, 0, ',', '.'),
            'keuntungan'        => number_format($keuntungan, 0, ',', '.'),
        ];
        return view('pimpinan.laporan.hari.detail', compact('user', 'data', 'namaHari'));
    }

    // penjualan per hari
    public function penjualanHari($hari)
    {
        $user = Auth::user();
        $penjualans = Penjualan::where('hari', $hari)->with('kasir')->get();

        return view('pimpinan.laporan.hari.penjualan', compact('user', 'penjualans'));
    }

    // absensi kasir
    public function absen()
    {
        $user = Auth::user();
        $kode = KodeAbsen::whereDate('created_at', Carbon::today())->first();
        if ($kode) {
            $qr = QrCode::size(450)->generate($kode->kode);
            return view('pimpinan.absen.absen', compact('user', 'kode', 'qr'));
        }
        return view('pimpinan.absen.absen', compact('user', 'kode'));
    }

    // kode absen
    public function kodeAbsen()
    {
        $created_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        $kodeAbsen = KodeAbsen::whereDate('created_at', $created_at)->first();
        if ($kodeAbsen) {
            return redirect()->route('pimpinan.absen')
                ->with('danger', 'Kode hari ini sudah ada!');
        }
        $kodeAbsen = KodeAbsen::where('kode', 0)->first();
        if (!$kodeAbsen) {
            $newKode = new KodeAbsen();
            $newKode->kode = mt_rand(100000, 999999);
            $newKode->created_at = $created_at;
            $newKode->save();
            return redirect()->route('pimpinan.absen')->with('success', 'Kode absen berhasil ditambahkan');
        }
        $kodeAbsen->kode = mt_rand(100000, 999999);
        $kodeAbsen->created_at = $created_at;
        $kodeAbsen->save();
        return redirect()->route('pimpinan.absen')->with('success', 'Kode absen berhasil ditampilkan');
    }

    // data detail hari tanpa param
    public function detailHari2()
    {
        $user = Auth::user();
        $hari = Carbon::now()->format('Y-m-d');
        $namaHari = LabaRugi::where('hari', $hari)->first();
        $penjualan = Penjualan::where('hari', $hari)->get()->count();
        $labaRugi = LabaRugi::where('hari', $hari)->first();
        $jumlah_barang = DetailPenjualan::whereDate('created_at', $hari)->sum('jumlah_barang');
        $pendapatan = $labaRugi->total_pemasukan;
        $detail_barang = DetailPenjualan::whereDate('created_at', $hari)->get();
        foreach ($detail_barang as $barang) {
            $barangDB = Barang::where('id', $barang->barang_id)->first();
            $keuntunganarr[] = $barang->jumlah_barang * ($barangDB->harga_jual - $barangDB->harga_beli);
            $keuntungan = array_sum($keuntunganarr);
            if ($keuntunganarr) {
                $keuntungan = array_sum($keuntunganarr);
            } else {
                $keuntungan  = 0;
            }
        }

        $data = [
            'penjualan'         => $penjualan,
            'jumlah_penjualan'  => $jumlah_barang,
            'pendapatan'        => number_format($pendapatan, 0, ',', '.'),
            'keuntungan'        => number_format($keuntungan, 0, ',', '.'),
        ];
        return view('pimpinan.laporan.hari.detail', compact('user', 'data', 'namaHari'));
    }

    // data detail bulan tanpa param
    public function detailBulan2()
    {
        $user = Auth::user();
        $bulan = Carbon::now()->format('Y-m');
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
}
