<?php

namespace App\Http\Controllers;

use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('kasir.member.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('kasir.member.create', compact('user'));
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
            'no_hp' => 'required|numeric|unique:members',
        ]);

        $member = new Member();
        $member->nama = $request->nama;
        $member->no_hp = $request->no_hp;
        $member->kode_member = Str::random(6);
        $member->hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $member->saldo = 0;
        $member->created_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        $member->save();

        return redirect()->route('member.index')->with('success', 'Data member berhasil ditambahkan');
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
        $member = Member::find($id);
        return view('kasir.member.edit', compact('user', 'member'));
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
            'no_hp' => 'required|numeric',
        ]);

        $member = Member::find($id);
        $member->nama = $request->nama;
        $member->no_hp = $request->no_hp;

        $member->save();

        return redirect()->route('member.index')->with('info', 'Data member berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::find($id);

        $member->delete();

        return redirect()->route('member.index')->with('danger', 'Data member berhasil dihapus');
    }
}
