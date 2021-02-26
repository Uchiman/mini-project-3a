<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Member\MemberCollection;
use App\Http\Resources\Member\MemberResource;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class MemberController extends Controller
{
    public function loginMember(Request $request)
    {

        $member = Member::where('no_hp', $request->no_hp)->first();
        if (!$member) {
            return Response()->json([
                "error" => "invalid_credentials"
            ], 400);
        }


        return response()->json([
            'status'  => 'success',
            'message' => 'berhasil login',
            'data'    =>  new MemberResource($member),
        ], Response::HTTP_OK);
    }

    public function registerMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|numeric|unique:members',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $member = new Member();
        $member->nama = $request->nama;
        $member->no_hp = $request->no_hp;
        $member->kode_member = Str::random(6);
        $member->hari = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d');
        $member->saldo = 0;
        $member->created_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        $member->save();

        return response()->json(compact('member'), 201);
    }

    // data semua member
    public function allMember()
    {
        $member = Member::all();
        return response()->json(new MemberCollection($member), Response::HTTP_OK);
    }

    // data member berdasarkan kode
    public function getMember($kode)
    {

        $member = Member::where('kode_member', $kode)->first();
        if (!$member) {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }
        return response()->json([
            'status'    =>  'success',
            'message'   =>  'transaksi berhasil',
            "data"      =>  new MemberResource($member),
        ], Response::HTTP_OK);
    }

    // edit member berdasarkan kode
    public function editMember(Request $request, $kode)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $member = Member::where('kode_member', $kode)->first();
        if (!$member) {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }

        $member->nama = $request->nama;
        $member->no_hp = $request->no_hp;
        $member->save();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'data berhasil ditampilkan',
            "data"      =>  new MemberResource($member),
        ], Response::HTTP_OK);
    }

    // hapus member
    public function hapusMember($kode)
    {
        $member = Member::where('kode_member', $kode)->first();
        if (!$member) {
            return Response()->json([
                "status" => "failed",
                "message" => "data tidak ditemukan",
            ], 400);
        }

        $member->delete();

        return response()->json([
            'status'    =>  'success',
            'message'   =>  'member berhasil dihapus',
        ], Response::HTTP_OK);
    }
}
