<?php

namespace App\Http\Controllers;

use App\Barang;
use App\DetailPenjualan;
use App\LabaRugi;
use App\LaporanStok;
use App\Member;
use App\Penjualan;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $penjualan = Penjualan::orderBy('id', 'DESC')->where('dibayar', null)->first();
        if (!$penjualan) {
            $detail_penjualans = [];
            return view('kasir.penjualan.index', compact('user', 'detail_penjualans'));
        }
        $detail_penjualans = DetailPenjualan::where('penjualan_id', $penjualan->id)->get();
        return view('kasir.penjualan.index', compact('user', 'detail_penjualans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $detail_penjualan = DetailPenjualan::find($id);
        $barang = Barang::where('id', $detail_penjualan->barang_id)->first();
        return view('kasir.penjualan.edit', compact('user', 'detail_penjualan', 'barang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_barang'          =>  'required|numeric',
        ]);

        $detail_penjualan = DetailPenjualan::find($id);
        $barang = Barang::where('id', $detail_penjualan->barang_id)->first();

        $detail_penjualan->jumlah_barang = $request->jumlah_barang;
        $detail_penjualan->harga_jual = $barang->harga_jual * $request->jumlah_barang;

        $detail_penjualan->save();

        return redirect()->route('penjualan.index')->with('info', 'Data barang berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail_penjualan = DetailPenjualan::find($id);

        $detail_penjualan->delete();

        return redirect()->route('penjualan.index')->with('danger', 'Data barang berhasil dihapus');
    }

    public function inputBarang(Request $request)
    {

        $request->validate([
            'kode'              =>  'required',
            'jumlah_barang'     =>  'required|numeric|min:0',
        ]);

        $barang = Barang::where('kode', $request->kode)->first();
        if (!$barang) {
            return redirect()->route('penjualan.index')
                ->with('danger', 'Barang tidak ditemukan!');
        }
        // dd($barang->harga_jual);
        $penjualan = Penjualan::where('status', 0)->first();
        if (!$penjualan) {
            $penjualan = new Penjualan();
            $penjualan->kasir_id = Auth::id();
            $penjualan->status = 0;
            $penjualan->save();
        }

        $detailPenjualan = DetailPenjualan::where('penjualan_id', $penjualan->id)->where('barang_id', $barang->id)->first();
        if (!$detailPenjualan) {
            $detailPenjualan = new DetailPenjualan();
            $detailPenjualan->penjualan_id = $penjualan->id;
            $detailPenjualan->barang_id = $barang->id;
            $detailPenjualan->jumlah_barang = $request->jumlah_barang;
            $detailPenjualan->harga_jual = $barang->harga_jual * $request->jumlah_barang;
            $detailPenjualan->diskon = $barang->diskon;
            $detailPenjualan->created_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
            $detailPenjualan->save();

            return redirect()->route('penjualan.index')->with('success', 'Data pengeluaran berhasil ditambahkan');
        }
        $detailPenjualan->jumlah_barang = $request->jumlah_barang + $detailPenjualan->jumlah_barang;
        $detailPenjualan->harga_jual = $barang->harga_jual * $detailPenjualan->jumlah_barang;
        $detailPenjualan->save();

        return redirect()->route('penjualan.index')->with('success', 'Data pengeluaran berhasil ditambahkan');
    }

    public function hasilPenjualan(Request $request)
    {
        $request->validate([
            'dibayar'              =>  'required',
        ]);

        $penjualan = Penjualan::where('status', '0')->first();
        // dd($penjualan);
        if (!$penjualan) {
            return redirect()->route('penjualan.index')
            ->with('danger', 'Input data terlebih dahulu!');
        }
        // update stok barang
        $detailPenjualan = DetailPenjualan::where('penjualan_id', $penjualan->id)->get();
        foreach ($detailPenjualan as $barang) {

            // masukkan ke database barang
            $barangDB = Barang::where('id', $barang->barang_id)->first();
            $barangDB->stok = $barangDB->stok - $barang->jumlah_barang;
            $barangDB->save();

            $hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
            $bulan = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m');

            // masukkan ke database stok
            $stokBarang = LaporanStok::where('hari', $hari)->where('bulan', $bulan)->where('barang_id', $barang->barang_id)->first();
            if (!$stokBarang) {
                $stokBarang = new LaporanStok();
                $stokBarang->barang_id      = $barang->barang_id;
                $stokBarang->terjual        = $barang->jumlah_barang - $barang->jumlah_barang;
                $stokBarang->sisa           = $barang->stok + $barang->jumlah_barang;
                $stokBarang->hari           = $hari;
                $stokBarang->bulan          = $bulan;
                $stokBarang->save();
            }
            $stokBarang->barang_id      = $barang->barang_id;
            $stokBarang->terjual        = $stokBarang->terjual + $barang->jumlah_barang;
            $stokBarang->sisa           = $stokBarang->sisa - $barang->jumlah_barang;
            $stokBarang->hari           = $hari;
            $stokBarang->bulan          = $bulan;
            $stokBarang->save();
        }

        if ($request->kode_member) {
            $penjualan->kode_member = $request->kode_member;
            // cek kode member
            $member = Member::where('kode_member', $request->kode_member)->first();
            if (!$member) {
                return redirect()->route('penjualan.index')
                ->with('danger', 'Member tidak ditemukan!');
            }
            $detailPenjualan = DetailPenjualan::where('penjualan_id', $penjualan->id)->get();
            foreach ($detailPenjualan as $barang) {
                $barang->harga_jual = $barang->harga_jual - ($barang->harga_jual * $barang->diskon / 100);

                $barang->update();
            }
        }

        $total_bayar = DetailPenjualan::where('penjualan_id', $penjualan->id)->sum('harga_jual');
        // update data penjualan
        $penjualan->dibayar = $request->dibayar;
        $penjualan->kode_member = $request->kode_member;
        $penjualan->total_bayar = $total_bayar;
        $penjualan->kembalian = $request->dibayar - $total_bayar;
        if ($penjualan->kembalian < 0) {
            return Response()->json([
                "status" => "failed",
                "message" => "uang tidak cukup",
            ], 400);
        }
        $penjualan->created_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        $hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $bulan = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m');
        $penjualan->hari = $hari;
        $penjualan->bulan = $bulan;
        $penjualan->status = 1;

        $penjualan->save();

        // memasukan ke database laba_rugi
        $labaRugi = LabaRugi::where('hari', $hari)->first();
        if (!$labaRugi) {
            $labaRugi = new LabaRugi();
            $labaRugi->created_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
            $labaRugi->total_pemasukan = $penjualan->total_bayar - $penjualan->total_bayar;
            $labaRugi->total_pengeluaran = 0;
            $labaRugi->hasil = $penjualan->total_bayar - $penjualan->total_bayar;
            $labaRugi->hari = $hari;
            $labaRugi->bulan = $bulan;
            $labaRugi->save();
        }
        $labaRugi->total_pemasukan = $labaRugi->total_pemasukan + $penjualan->total_bayar;
        $labaRugi->hasil = $labaRugi->hasil + $penjualan->total_bayar;
        $labaRugi->save();

        return redirect()->route('kasir.hasil')->with('success', 'Data pengeluaran berhasil ditambahkan');
    }

    public function hasil()
    {
        $user = Auth::user();
        $penjualan = Penjualan::latest()->first();
        $detail_penjualans = DetailPenjualan::where('penjualan_id', $penjualan->id)->get();
        $kasir = User::where('id', $penjualan->kasir_id)->first();
        return view('kasir.penjualan.result', compact('user', 'detail_penjualans', 'penjualan', 'kasir'));
    }
}
