<?php

namespace App\Http\Controllers\API;

use App\DetailPenjualan;
use App\Http\Controllers\Controller;
use App\Http\Resources\Bulan\BulanCollection;
use App\Http\Resources\DetailPenjualan\DetailPenjualanCollection;
use App\Http\Resources\Hari\HariCollection;
use App\Http\Resources\Laporan\LaporanCollection;
use App\Http\Resources\Laporan\LaporanResource;
use App\Http\Resources\LaporanStok\LaporanStokCollection;
use App\Http\Resources\Pembelian\PembelianCollection;
use App\Http\Resources\Penjualan\PenjualanCollection;
use App\Kategori;
use App\LabaRugi;
use App\LaporanStok;
use App\Pembelian;
use App\Pengeluaran;
use App\Penjualan;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PimpinanController extends Controller
{
    /**
     * LAPORAN DATA STOK BARANG
     *
     * @return void
     */

    // laporan stok barang per bulan
    public function stokBarangPerBulan($bulan)
    {
        $stokBarang = LaporanStok::where('bulan', $bulan)->orderBy('id', 'DESC')->get();

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

        if ($stokBarang == "[]") {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }

        return response()->json(new LaporanStokCollection($res), Response::HTTP_OK);
    }

    /**
     * LAPORAN DATA PEMBELIAN BARANG
     *
     * @return void
     */

    // laporan data pembelian per bulan
    public function dataPembelianPerBulan($bulan)
    {
        $pembelian = Pembelian::where('bulan', $bulan)->get();
        if ($pembelian == "[]") {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        return response()->json(new PembelianCollection($pembelian), Response::HTTP_OK);
    }

    /**
     * LAPORAN DATA PENJUALAN BARANG
     * @return void
     */

    // laporan data penjualan per bulan
    public function dataPenjualanPerBulan($bulan)
    {
        $penjualan = Penjualan::where('bulan', $bulan)->get();
        if ($penjualan == "[]") {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        return response()->json(new PenjualanCollection($penjualan), Response::HTTP_OK);
    }

    //laporan detaip penjualan barang
    public function detailPenjualan($id)
    {
        $penjualan = Penjualan::where('id', $id)->first();
        $detailPenjualan = DetailPenjualan::where('penjualan_id', $penjualan->id)->get();

        return response()->json(new DetailPenjualanCollection($detailPenjualan), Response::HTTP_OK);
    }

    /**
     * LAPORAN PIMPINAN TRANSAKSI PEMBELIAN, PENJUALAN DAN LABA RUGI
     * @return void
     */

    // mengambil data bulan
    public function dataBulan()
    {
        $bulan = LaporanStok::all()->unique('bulan');
        if ($bulan == "[]") {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        return response()->json(new BulanCollection($bulan), Response::HTTP_OK);
    }

    // mengambil data tanggal
    public function dataHari($bulan)
    {
        $hari = LaporanStok::where('bulan', $bulan)->get()->unique('hari');
        if ($hari == "[]") {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        return response()->json(new HariCollection($hari), Response::HTTP_OK);
    }

    // laporan pembelian, penjualan dan laba rugi
    public function laporanPimpinan($bulan)
    {
        $pembelian = Pembelian::where('bulan', $bulan)->get()->count();
        $penjualan = Penjualan::where('bulan', $bulan)->get()->count();
        $namaBulan = LabaRugi::where('bulan', $bulan)->first();
        if (!$namaBulan) {
            $namaBulan = "Belum ada data masuk";
        }

        $pemasukan = LabaRugi::where('bulan', $bulan)->get()->sum('total_pemasukan');
        $pengeluaran = LabaRugi::where('bulan', $bulan)->get()->sum('total_pengeluaran');
        $labaRugi = LabaRugi::where('bulan', $bulan)->get()->sum('hasil');
        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil ditampilkan',
            "data"      =>  [
                'pembelian' => $pembelian ?: 0,
                'penjualan' => $penjualan ?: 0,
                'pemasukan' => number_format($pemasukan, 0, ',', '.') ?: 0,
                'pengeluaran' => number_format($pengeluaran, 0, ',', '.') ?: 0,
                'laba_rugi' => number_format($labaRugi, 0, ',', '.') ?: 0,
                "bulan" => $bulan,
                "nama" => $namaBulan->created_at->format('F'),
            ],
        ], Response::HTTP_OK);
    }

    // laporan laba rugi per hari
    public function laporanLabaRugi($hari)
    {
        $labaRugi = LabaRugi::where('hari', $hari)->first();
        if ($labaRugi == "[]") {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil ditampilkan',
            "data"      =>  new LaporanResource($labaRugi),
        ]);
    }

    /**
     * PENGELUARAN
     * @return void
     */

    // input pengeluaran 
    public function inputPengeluaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keterangan'      =>  'required',
            'biaya'           =>  'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $bulan = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m');

        $pengeluaran = new Pengeluaran();
        $pengeluaran->keterangan = $request->keterangan;
        $pengeluaran->biaya = $request->biaya;
        $pengeluaran->bulan = $bulan;
        $pengeluaran->hari = $hari;

        $pengeluaran->save();

        // masukkan ke database laba_rugi
        $labaRugi = LabaRugi::where('hari', $hari)->first();
        if (!$labaRugi) {
            $labaRugi = new LabaRugi();
            $labaRugi->total_pemasukan = 0;
            $labaRugi->created_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
            $labaRugi->total_pengeluaran = $pengeluaran->biaya - $pengeluaran->biaya;
            $labaRugi->hasil = $pengeluaran->biaya - $pengeluaran->biaya;
            $labaRugi->hari = $hari;
            $labaRugi->bulan = $bulan;
            $labaRugi->save();
        }
        $labaRugi->total_pengeluaran = $labaRugi->total_pengeluaran + $pengeluaran->biaya;
        $labaRugi->hasil = $labaRugi->hasil - $pengeluaran->biaya;
        $labaRugi->save();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil ditampilkan',
            "data"      =>  $pengeluaran,
        ], Response::HTTP_OK);
    }

    // melihat data pengeluaran semua
    public function semuaPengeluaran()
    {
        $pengeluaran = Pengeluaran::all();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil ditampilkan',
            "data"      =>  $pengeluaran,
        ], Response::HTTP_OK);
    }


    // update data pengeluaran
    public function updatePengeluaran(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'keterangan'      =>  'required',
            'biaya'           =>  'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $bulan = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m');

        $pengeluaran = Pengeluaran::where('id', $id)->first();
        $pengeluaran->keterangan = $request->keterangan;
        $pengeluaran->biaya = $request->biaya;
        $pengeluaran->bulan = $bulan;
        $pengeluaran->hari = $hari;

        $pengeluaran->save();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil ditampilkan',
            "data"      =>  $pengeluaran,
        ], Response::HTTP_OK);
    }

    // delete pengeluaran
    public function deletePengeluaran($id)
    {
        $pengeluaran = Pengeluaran::where('id', $id)->first();
        $pengeluaran->delete();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil dihapus',
        ], Response::HTTP_OK);
    }

    /**
     * SUPPLIERS
     * @return void
     */

    // input supplier 
    public function inputSupplier(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'          =>  'required',
            'alamat'        =>  'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $supplier = new Supplier();
        $supplier->nama = $request->nama;
        $supplier->alamat = $request->alamat;

        $supplier->save();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil ditampilkan',
            "data"      =>  $supplier,
        ], Response::HTTP_OK);
    }

    // melihat data pengeluaran semua
    public function semuaSupplier()
    {
        $supplier = Supplier::all();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil ditampilkan',
            "data"      =>  $supplier,
        ], Response::HTTP_OK);
    }


    // update data pengeluaran
    public function updateSupplier(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama'          =>  'required',
            'alamat'        =>  'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $supplier = Supplier::where('id', $id)->first();

        $supplier->nama = $request->nama;
        $supplier->alamat = $request->alamat;

        $supplier->save();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil ditampilkan',
            "data"      =>  $supplier,
        ], Response::HTTP_OK);
    }

    // delete supplier
    public function deleteSupplier($id)
    {
        $supplier = Supplier::where('id', $id)->first();
        $supplier->delete();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil dihapus',
        ], Response::HTTP_OK);
    }

    /**
     * KATEGORI
     * @return void
     */

    // input kategori 
    public function inputKategori(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'          =>  'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $kategori = new Kategori();
        $kategori->nama = $request->nama;

        $kategori->save();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil ditampilkan',
            "data"      =>  $kategori,
        ], Response::HTTP_OK);
    }

    // melihat data pengeluaran semua
    public function semuaKategori()
    {
        $kategori = Kategori::all();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil ditampilkan',
            "data"      =>  $kategori,
        ], Response::HTTP_OK);
    }


    // update data pengeluaran
    public function updateKategori(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama'          =>  'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $kategori = Kategori::where('id', $id)->first();

        $kategori->nama = $request->nama;

        $kategori->save();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil ditampilkan',
            "data"      =>  $kategori,
        ], Response::HTTP_OK);
    }

    // delete kategori
    public function deleteKategori($id)
    {
        $kategori = Kategori::where('id', $id)->first();
        $kategori->delete();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil dihapus',
        ], Response::HTTP_OK);
    }
}
