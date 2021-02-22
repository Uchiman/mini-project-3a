<?php

namespace App\Http\Controllers\API;

use App\Absen;
use App\Barang;
use App\DetailPenjualan;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailPenjualan\DetailPenjualanCollection;
use App\Http\Resources\DetailPenjualan\DetailPenjualanResource;
use App\Http\Resources\Penjualan\PenjualanCollection;
use App\Http\Resources\Penjualan\PenjualanResource;
use App\Kasir;
use App\KodeAbsen;
use App\LabaRugi;
use App\LaporanStok;
use App\Member;
use App\Penjualan;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class KasirController extends Controller
{
    // kasir post penjualan per barang
    public function detailPenjualan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode'       =>  'required',
            'jumlah_barang'     =>  'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $barang = Barang::where('kode', $request->kode)->first();
        if (!$barang) {
            return Response()->json([
                "status" => "failed",
                "message" => "barang tidak diketahui",
            ], 400);
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

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'berhasil input barang',
                "data"      =>  [new DetailPenjualanResource($detailPenjualan)],
            ], Response::HTTP_OK);
        }
        $detailPenjualan->jumlah_barang = $request->jumlah_barang + $detailPenjualan->jumlah_barang;
        $detailPenjualan->harga_jual = $barang->harga_jual * $detailPenjualan->jumlah_barang;
        $detailPenjualan->save();

        $dataPenjualan = DetailPenjualan::where('penjualan_id', $penjualan->id)->get();
        return response()->json(new DetailPenjualanCollection($dataPenjualan), Response::HTTP_OK);
    }

    // kasir post hasil penjualan
    public function hasilPenjualan(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'dibayar'           =>  'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $penjualan = Penjualan::where('status', '0')->first();
        // dd($penjualan);
        if (!$penjualan) {
            return Response()->json([
                "status" => "failed",
                "message" => "input per barangnya dulu, baru pake api ini",
            ], 400);
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
                return Response()->json([
                    "status" => "failed",
                    "message" => "member tidak ditemukan",
                ], 400);
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

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'transaksi berhasil',
            "data"      =>  new PenjualanResource($penjualan),
        ], Response::HTTP_OK);
    }

    // menampilkan detail data penjualan per barang
    public function kuitansi1()
    {
        $dataPenjualan = Penjualan::where('status', 0)->first();
        if (!$dataPenjualan) {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        $dataTerakhir = DetailPenjualan::where('penjualan_id', $dataPenjualan->id)->first();
        $dataPenjualan = DetailPenjualan::where('penjualan_id', $dataTerakhir->penjualan_id)->get();
        return response()->json(new DetailPenjualanCollection($dataPenjualan), Response::HTTP_OK);
    }

    // menampilkan total data penjualan
    public function kuitansi2()
    {
        $dataPenjualan = Penjualan::latest()->first();
        return response()->json([
            'status'    =>  'success',
            'message'   =>  'transaksi berhasil',
            "data"      =>  new PenjualanResource($dataPenjualan),
        ], Response::HTTP_OK);
    }

    // menampilkan total data penjualan (untuk kuitansi)
    public function kuitansi3()
    {
        $dataTerakhir = DetailPenjualan::latest()->first();
        $dataPenjualan = DetailPenjualan::where('penjualan_id', $dataTerakhir->penjualan_id)->get();
        return response()->json(new DetailPenjualanCollection($dataPenjualan), Response::HTTP_OK);
    }

    // update data penjualan per barang
    public function updateData(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_barang'     =>  'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    =>  "failed",
                'message'   =>  $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $penjualan = Penjualan::where('status', 0)->first();
        if (!$penjualan) {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        $detailPenjualan = DetailPenjualan::where('penjualan_id', $penjualan->id)->where('id', $id)->first();
        // cari barang berdasarkan detail penjualan
        $barang = Barang::where('id', $detailPenjualan->barang_id)->first();
        // update database detail penjualan
        $detailPenjualan->jumlah_barang = $request->jumlah_barang;
        $detailPenjualan->harga_jual = $barang->harga_jual * $request->jumlah_barang;
        $detailPenjualan->save();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'update data berhasil',
            "data"      =>  new DetailPenjualanResource($detailPenjualan),
        ], Response::HTTP_OK);
    }

    // hapus data penjualan per barang
    public function destroyData($id)
    {
        $penjualan = Penjualan::where('status', 0)->first();
        if (!$penjualan) {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        $detailPenjualan = DetailPenjualan::where('penjualan_id', $penjualan->id)->where('id', $id)->first();
        if (!$detailPenjualan) {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        $detailPenjualan->delete();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'hapus data berhasil',
        ], Response::HTTP_OK);
    }

    // absen harian
    public function absen(Request $request)
    {
        $hari_ini = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        $user_id = Auth::id();
        $kode = KodeAbsen::whereDate('created_at', $hari_ini)->first();
        if (!$kode) {
            return Response()->json([
                "status" => "failed",
                "message" => "absen belum dibuka",
            ], 400);
        }
        $absen = Absen::whereDate('created_at', $hari_ini)->where('user_id', $user_id)->first();
        if ($absen) {
            return Response()->json([
                "status" => "failed",
                "message" => "sudah absen hari ini",
            ], 400);
        }
        $absen = new Absen();
        $absen->kode_id = $request->kode;
        if ($request->kode != $kode->kode) {
            return Response()->json([
                "status" => "failed",
                "message" => "kode salah",
            ], 400);
        }
        $absen->user_id = $user_id;
        $absen->created_at = $hari_ini;
        $absen->kode_id = $kode->id;
        $absen->absen = true;
        $absen->save();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'absen berhasil',
        ], Response::HTTP_OK);
    }

    // status absen per bulan
    public function dataAbsen()
    {
        $user_id = Auth::id();
        $bulan_ini = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('m');
        $tahun_ini = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y');
        $absen = Absen::where('user_id', $user_id)->whereYear('created_at', $tahun_ini)->whereMonth('created_at', $bulan_ini)->get();
        $dataAbsen = KodeAbsen::whereYear('created_at', $tahun_ini)->whereMonth('created_at', $bulan_ini)->get();

        $totalAbsen = count($dataAbsen);
        $absenUser = count($absen);
        if ($absenUser == 0) {
            return response()->json([
                'status'    =>  'success',
                'message'   =>  'persentase absensi bulan ini',
                'data'      => 0,
            ], Response::HTTP_OK);
        }
        $hasil = $totalAbsen * 100 / $absenUser;
        return response()->json([
            'status'    =>  'success',
            'message'   =>  'persentase absensi bulan ini',
            'data'      => $hasil ?: 0,
        ], Response::HTTP_OK);
    }
}
