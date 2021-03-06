<?php

namespace App\Http\Controllers;

use App\Kasir;
use App\Mail\SendMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $kasir = Kasir::where('user_id', Auth::id())->first();
        $role = $user->getRoleNames();

        return view('menu.info', compact('user', 'kasir', 'role'));
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
        $user = User::find($id);
        $kasir = Kasir::where('user_id', Auth::id())->first();

        return view('menu.edit', compact('user', 'kasir'));
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
        $user = User::find($id);
        $role = $user->getRoleNames();
        $user->name = $request->nama;

        $user->save();

        $kasir = Kasir::where('user_id', Auth::id())->first();
        if ($kasir) {
            $kasir->umur = $request->umur;
            $kasir->alamat = $request->alamat;

            $kasir->save();
        }

        if ($role[0] == 'kasir') {
            $kasir = new Kasir();
            $kasir->user_id = $user->id;
            $kasir->umur = $request->umur;
            $kasir->alamat = $request->alamat;
            
            $kasir->save();
        }

        return redirect()->route('akun.index')->with('info', 'Data user berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // kirim kode vertifikasi 
    public function sendMail()
    {
        $user = Auth::user();
        $nama = $user->name;
        $email = $user->email;
        $kode = mt_rand(1000, 9999);

        $user = User::where('email', $email)->first();
        $user->kode = $kode;
        $user->save();
        Mail::to($email)->send(new SendMail($nama, $kode));

        return redirect()->route('akun.vertifikasi')->with('info', 'Kode vertifikasi dikirim ke email anda');
    }

    // view vertifikasi email
    public function viewEmail()
    {
        $user = Auth::user();
        return view('menu.vertifikasi', compact('user'));

    }

    // vertifikasi email
    public function verifyEmail(Request $request)
    {
        $user = Auth::user();

        $user = User::where('email', $user->email)->first();
        if ($user->email_verified_at == null) {
            if ($request->kode == $user->kode) {
                $user->email_verified_at = (Carbon::now(new \DateTimeZone('Asia/Jakarta')));
                $user->save();

                return redirect()->route('akun.index')->with('info', 'vertifikasi email berhasil');
            } else {
                return redirect()->route('akun.vertifikasi')->with('danger', 'kode vertifikasi tidak sesuai');
            }
        } else {
            return redirect()->route('akun.vertifikasi')->with('danger', 'email sudah ter-vertifikasi');
        }
    }
}
