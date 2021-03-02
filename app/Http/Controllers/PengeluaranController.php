<?php

namespace App\Http\Controllers;

use App\LabaRugi;
use App\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('staff.pengeluaran.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('staff.pengeluaran.create', compact('user'));
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
            'keterangan'          =>  'required',
            'biaya'        =>  'required|numeric',
        ]);

        $hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $bulan = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m');

        $pengeluaran = new Pengeluaran();
        $pengeluaran->keterangan    = $request->keterangan;
        $pengeluaran->biaya         = $request->biaya;
        $pengeluaran->hari          = $hari;
        $pengeluaran->bulan         = $bulan;
        $pengeluaran->user_id       = Auth::id();

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

        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil ditambahkan');
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
        $pengeluaran = Pengeluaran::find($id);
        return view('staff.pengeluaran.edit', compact('user', 'pengeluaran'));
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
            'keterangan'          =>  'required',
            'biaya'        =>  'required|numeric',
        ]);

        $hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $bulan = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m');

        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->keterangan = $request->keterangan;
        $pengeluaran->biaya = $request->biaya;
        $pengeluaran->hari = $hari;
        $pengeluaran->bulan = $bulan;


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

        $pengeluaranDB = Pengeluaran::where('id', $id)->first();
        $labaRugi->total_pengeluaran = $labaRugi->total_pengeluaran - $pengeluaranDB->biaya + $pengeluaran->biaya;
        $labaRugi->hasil = $labaRugi->hasil - $pengeluaran->biaya + $pengeluaranDB->biaya;

        $pengeluaran->update();
        $labaRugi->save();

        return redirect()->route('pengeluaran.index')->with('info', 'Data pengeluaran berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $hari = $pengeluaran->hari;
        $labaRugi = LabaRugi::where('hari', $hari)->first();

        $labaRugi->total_pengeluaran = $labaRugi->total_pengeluaran - $pengeluaran->biaya;
        $labaRugi->hasil = $labaRugi->hasil + $pengeluaran->biaya;

        $labaRugi->save();
        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')
            ->with('danger', 'Data pengeluaran berhasil dihapus');
    }
}
