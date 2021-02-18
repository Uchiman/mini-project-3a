<?php

namespace App\Http\Controllers\API;

use App\Barang;
use App\Http\Controllers\Controller;
use App\Http\Resources\Barang\BarangCollection;
use App\Http\Resources\Kategori\KategoriCollection;
use App\Http\Resources\Pembelian\PembelianCollection;
use App\Http\Resources\TanggalPembelian\TanggalPembelianCollection;
use App\Kategori;
use App\LabaRugi;
use App\LaporanStok;
use App\Pembelian;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class StaffController extends Controller
{
    // input data barang
    public function inputBarang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'     =>  'required',
            'harga_beli'     =>  'required|numeric|min:0',
            'harga_jual'     =>  'required|numeric|min:0',
            'kategori_id'     =>  'required',
            'merek'     =>  'required',
            'stok'     =>  'required|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

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

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'berhasil input barang',
                "data"      =>  $barang,
            ], Response::HTTP_OK);
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

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'berhasil input barang',
            "data"      =>  $barang,
        ], Response::HTTP_OK);
    }

    // input transaksi pembelian
    public function pembelianBarang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier'     =>  'required',
            'barang'     =>  'required',
            'total_barang'     =>  'required|numeric|min:0',
            'total_bayar'     =>  'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

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

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'berhasil Input Barang',
            "data"      =>  $pembelian,
        ], Response::HTTP_OK);
    }

    // melihat data barang
    public function dataBarang()
    {
        $barang = Barang::all();
        if ($barang == "[]") {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        return response()->json(new BarangCollection($barang), Response::HTTP_OK);
    }

    // melihat data transaksi
    public function dataPembelian()
    {
        $pembelian = Pembelian::all();
        if ($pembelian == "[]") {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        return response()->json(new PembelianCollection($pembelian), Response::HTTP_OK);
    }

    // melihat kategori barang
    public function kategoriBarang()
    {
        $kategori = Kategori::all();
        if ($kategori == "[]") {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        return response()->json(new KategoriCollection($kategori), Response::HTTP_OK);
    }

    // melihat data barang per kategori
    public function barangPerKategori($id)
    {
        $barang = Barang::where('kategori_id', $id)->get();
        if ($barang == "[]") {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        return response()->json(new BarangCollection($barang), Response::HTTP_OK);
    }

    // melihat tanggal pembelian barang(berbentuk kode)
    public function tanggalPembelian()
    {
        $tanggalPembelian = Pembelian::all()->unique('bulan');
        if ($tanggalPembelian == "[]") {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        return response()->json(new TanggalPembelianCollection($tanggalPembelian), Response::HTTP_OK);
    }

    // melihat data pembelian per tanggal
    public function pembelianPerTanggal($id)
    {
        $pembelian = Pembelian::where('hari', $id)->get();
        if ($pembelian == "[]") {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        return response()->json(new PembelianCollection($pembelian), Response::HTTP_OK);
    }

    // update data barang
    public function updateBarang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama'     =>  'required',
            'harga_beli'     =>  'required|numeric|min:0',
            'harga_jual'     =>  'required|numeric|min:0',
            'kategori_id'     =>  'required',
            'merek'     =>  'required',
            'stok'     =>  'required|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $barang = Barang::where('id', $id)->first();
        if (!$barang) {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }

        $barang->nama           = $request->nama;
        $barang->harga_beli     = $request->harga_beli;
        $barang->harga_jual     = $request->harga_jual;
        $barang->kategori_id    = $request->kategori_id;
        $barang->merek          = $request->merek;
        $barang->stok           = $request->stok;
        $barang->diskon         = $request->diskon ?: 0;

        $barang->update();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'berhasil update barang',
            "data"      =>  $barang,
        ], Response::HTTP_OK);
    }

    // delete data barang
    public function deleteBarang($id)
    {
        $barang = Barang::where('id', $id)->first();
        $barang->delete();
        return response()->json([
            'status'    =>  'success',
            'message'   =>  'berhasil hapus barang',
            "data"      =>  $barang,
        ], Response::HTTP_OK);
    }

    // update data pembelian
    public function updatePembelian(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'supplier'     =>  'required',
            'barang'     =>  'required',
            'total_barang'     =>  'required|numeric|min:0',
            'total_bayar'     =>  'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $pembelian = Pembelian::where('id', $id)->first();
        $pembelian->supplier            = $request->supplier;
        $pembelian->barang              = $request->barang;
        $pembelian->total_barang        = $request->total_barang;
        $pembelian->total_bayar         = $request->total_bayar;

        $pembelian->update();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'berhasil update barang',
            "data"      =>  $pembelian,
        ], Response::HTTP_OK);
    }

    // delete data pembelian
    public function deletePembelian($id)
    {
        $pembelian = Pembelian::where('id', $id)->first();
        $pembelian->delete();
        return response()->json([
            'status'    =>  'success',
            'message'   =>  'berhasil hapus barang',
            "data"      =>  $pembelian,
        ], Response::HTTP_OK);
    }
}
