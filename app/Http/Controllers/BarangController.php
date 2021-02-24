<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Kategori;
use App\LaporanStok;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('staff.barang.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $kategoris = Kategori::all();
        return view('staff.barang.create', compact('user', 'kategoris'));
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
            'nama' => 'required|string|max:255',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'merek' => 'required|string|max:255',
            'stok' => 'required|integer',
            'diskon' => 'required|integer|min:0',
        ]);

        $barang = Barang::where('nama', $request->nama)->first();
        if (!$barang) {
            $barang = new Barang();
            $barang->nama           = $request->nama;
            $barang->kode           = mt_rand(100000, 999999);
            $barang->harga_beli     = $request->harga_beli;
            $barang->harga_jual     = $request->harga_jual;
            $barang->kategori_id    = $request->kategori_id;
            $barang->merek          = $request->merek;
            $barang->stok           = $request->stok;
            $barang->diskon         = $request->diskon ?: 0;

            $barang->save();

            // masukkan ke database stok
            $stokBarang = new LaporanStok();
            $stokBarang->barang_id = $barang->id;
            $stokBarang->barang_masuk = $barang->stok;
            $stokBarang->sisa = $barang->stok;
            $stokBarang->hari =  Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
            $stokBarang->bulan =  Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m');
            $stokBarang->save();

            return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan');
        }
        $barang = Barang::where('nama', $request->nama)->first();
        $barang->stok = $barang->stok + $request->stok;

        $barang->save();

        $hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $bulan = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m');

        // masukkan ke database stok
        $stokBarang = LaporanStok::where('hari', $hari)->where('bulan', $bulan)->where('barang_id', $barang->id)->first();
        if (!$stokBarang) {
            $stokBarang = new LaporanStok();
            $stokBarang->barang_id = $barang->id;
            $stokBarang->barang_masuk = $barang->stok - $barang->stok;
            $stokBarang->sisa = $barang->stok;
            $stokBarang->hari =  $hari;
            $stokBarang->bulan =  $bulan;
            $stokBarang->save();
        }
        $stokBarang->barang_id = $barang->id;
        $stokBarang->barang_masuk =  $request->stok + $stokBarang->barang_masuk;
        $stokBarang->sisa = $barang->stok;
        $stokBarang->hari =  $hari;
        $stokBarang->bulan =  $bulan;
        $stokBarang->save();


        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan');
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
        $barang = Barang::find($id);
        $kategoris = Kategori::all();
        return view('staff.barang.edit', compact('user', 'barang', 'kategoris'));
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
            'nama' => 'required|string|max:255',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'merek' => 'required|string|max:255',
            'stok' => 'required|integer',
            'diskon' => 'required|integer',
        ]);

        $barang = Barang::find($id);
        $barang->nama           = $request->nama;
        $barang->kode           = mt_rand(100000, 999999);
        $barang->harga_beli     = $request->harga_beli;
        $barang->harga_jual     = $request->harga_jual;
        $barang->kategori_id    = $request->kategori_id;
        $barang->merek          = $request->merek;
        $barang->stok           = $request->stok;
        $barang->diskon         = $request->diskon ?: 0;

        $barang->save();

        $hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $bulan = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m');

        // masukkan ke database stok
        $stokBarang = LaporanStok::where('hari', $hari)->where('bulan', $bulan)->where('barang_id', $barang->id)->first();
        if (!$stokBarang) {
            $stokBarang = new LaporanStok();
            $stokBarang->barang_id = $barang->id;
            $stokBarang->barang_masuk = $barang->stok - $barang->stok;
            $stokBarang->sisa = $barang->stok;
            $stokBarang->hari =  $hari;
            $stokBarang->bulan =  $bulan;
            $stokBarang->save();
        }
        $stokBarang->barang_id = $barang->id;
        $stokBarang->barang_masuk =  $request->stok;
        $stokBarang->sisa = $barang->stok;
        $stokBarang->hari =  $hari;
        $stokBarang->bulan =  $bulan;
        $stokBarang->save();

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);
        $stokBarang = LaporanStok::where('barang_id', $id)->get();
        foreach ($stokBarang as $stok) {
            $stok->delete();
        }
        $barang->delete();
        return redirect()->route('barang.index')
            ->with('danger', 'Data barang berhasil dihapus');
    }
}
