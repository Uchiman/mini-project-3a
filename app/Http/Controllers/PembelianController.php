<?php

namespace App\Http\Controllers;

use App\LabaRugi;
use App\Pembelian;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('staff.pembelian.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('staff.pembelian.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier'     =>  'required',
            'barang'     =>  'required',
            'total_barang'     =>  'required|numeric|min:0',
            'total_bayar'     =>  'required|numeric',
        ]);

        // masukkan ke database pembelian
        $pembelian = new Pembelian();
        // jika supplier tidak ditemukan
        $supplier = Supplier::where('nama', $request->supplier)->first();
        // dd($supplier);
        if (!$supplier) {
            $supplier = new Supplier();
            $supplier->nama = $request->supplier;
            $supplier->save();
        }
        $pembelian->supplier            = $request->supplier;
        $pembelian->barang              = $request->barang;
        $pembelian->total_barang        = $request->total_barang;
        $pembelian->total_bayar         = $request->total_bayar;
        $pembelian->hari                = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $pembelian->bulan               = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m');

        $pembelian->save();

        $hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $bulan = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m');
        // masukkan ke database laba_rugi
        $labaRugi = LabaRugi::where('hari', $hari)->first();
        if (!$labaRugi) {
            $labaRugi = new LabaRugi();
            $labaRugi->total_pemasukan = 0;
            $labaRugi->created_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
            $labaRugi->total_pengeluaran = $pembelian->total_bayar - $pembelian->total_bayar;
            $labaRugi->hasil = $pembelian->total_bayar - $pembelian->total_bayar;
            $labaRugi->hari = $hari;
            $labaRugi->bulan = $bulan;
            $labaRugi->save();
        }
        $labaRugi->total_pengeluaran = $labaRugi->total_pengeluaran + $pembelian->total_bayar;
        $labaRugi->hasil = $labaRugi->hasil - $pembelian->total_bayar;
        $labaRugi->save();

        return redirect()->route('pembelian.index')->with('success', 'Data transaksi pembelian berhasil ditambahkan');
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
        $pembelian = Pembelian::find($id);
        return view('staff.pembelian.edit', compact('user', 'pembelian'));
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
            'supplier'     =>  'required',
            'barang'     =>  'required',
            'total_barang'     =>  'required|numeric|min:0',
            'total_bayar'     =>  'required|numeric',
        ]);

        $pembelian = Pembelian::where('id', $id)->first();
        $pembelian->supplier            = $request->supplier;
        $pembelian->barang              = $request->barang;
        $pembelian->total_barang        = $request->total_barang;
        $pembelian->total_bayar         = $request->total_bayar;
        $pembelian->hari                = $request->hari;

        


        $hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $bulan = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m');
        // masukkan ke database laba_rugi
        $labaRugi = LabaRugi::where('hari', $hari)->first();
        if (!$labaRugi) {
            $labaRugi = new LabaRugi();
            $labaRugi->total_pemasukan = 0;
            $labaRugi->created_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
            $labaRugi->total_pengeluaran = $pembelian->total_bayar - $pembelian->total_bayar;
            $labaRugi->hasil = $pembelian->total_bayar - $pembelian->total_bayar;
            $labaRugi->hari = $hari;
            $labaRugi->bulan = $bulan;
            $labaRugi->save();
        }
    
        $pembelianDB = Pembelian::where('id', $id)->first();
        $labaRugi->total_pengeluaran = $labaRugi->total_pengeluaran - $pembelianDB->total_bayar + $pembelian->total_bayar;
        $labaRugi->hasil = $labaRugi->hasil - $pembelian->total_bayar + $pembelianDB->total_bayar ;

        $pembelian->update();
        $labaRugi->save();

        return redirect()->route('pembelian.index')->with('info', 'Data transaksi pembelian berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);
        $hari = $pembelian->hari;
        $labaRugi = LabaRugi::where('hari', $hari)->first();

        $labaRugi->total_pengeluaran = $labaRugi->total_pengeluaran - $pembelian->total_bayar;
        $labaRugi->hasil = $labaRugi->hasil + $pembelian->total_bayar;

        $labaRugi->save();
        $pembelian->delete();

        return redirect()->route('pembelian.index')
            ->with('danger', 'Data pembelian berhasil dihapus');
    }
}
