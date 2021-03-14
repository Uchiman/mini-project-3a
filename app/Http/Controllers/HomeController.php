<?php

namespace App\Http\Controllers;

use App\Absen;
use App\Barang;
use App\Kategori;
use App\LabaRugi;
use App\Member;
use App\Pembelian;
use App\Penjualan;
use App\Supplier;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return view('templates.welcome', compact('user'));
    }

    // home staff
    public function staff()
    {
        $user = Auth::user();
        $pembelian = Pembelian::all()->count();
        $barang = Barang::all()->count();
        $supplier = Supplier::all()->count();
        $kategori = Kategori::all()->count();
        $data = [];
        $data = [
            'pembelian' => $pembelian,
            'barang' => $barang,
            'supplier' => $supplier,
            'kategori' => $kategori
        ];

        return view('staff.home', compact('user', 'data'));
    }

    // home kasir
    public function kasir()
    {
        $user = Auth::user();
        $hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $penjualan = Penjualan::where('hari', $hari)->get()->count();
        $member = Member::all()->count();
        $labaRugi = LabaRugi::where('hari', $hari)->first();
        $today = Carbon::today();
        $absen = Absen::where('user_id', $user->id)->whereDate('created_at', $today)->first();
        $data = [];
        if ($labaRugi == null) {
            $pendapatan = 0;
            $data = [
                'penjualan'         => $penjualan,
                'member'            => $member,
                'pendapatan'        => number_format($pendapatan, 0, ',', '.'),
                'hari'              => $today,
            ];

            return view('kasir.home', compact('user', 'data', 'absen'));
        }

        $pendapatan = $labaRugi->total_pemasukan;
        $data = [
            'penjualan'         => $penjualan,
            'member'            => $member,
            'pendapatan'        => number_format($pendapatan, 0, ',', '.'),
            'hari'              => $today,
        ];

        return view('kasir.home', compact('user', 'data', 'absen'));
    }

    // home pimpinan
    public function pimpinan()
    {
        $user = Auth::user();
        $barang = Barang::all()->count();
        $bulan = Carbon::now()->isoFormat('MMMM');
        $hari = Carbon::now()->isoFormat('dddd');
        return view('pimpinan.home', compact('user', 'barang', 'bulan', 'hari'));
    }

    // home admin
    public function admin()
    {
        $user = Auth::user();
        $users = User::role(['staff', 'pimpinan', 'kasir'])->count();

        return view('admin.home', compact('user', 'users'));
    }
}
