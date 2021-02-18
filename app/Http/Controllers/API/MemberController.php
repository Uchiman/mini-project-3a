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
            'kode_member' => 'numeric|min:6|unique:members',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $member = Member::create([
            'nama' => $request->get('nama'),
            'no_hp' => $request->get('no_hp'),
            'kode_member' => Str::random(6),
            'created_at' => Carbon::now(new \DateTimeZone('Asia/Jakarta')),
            'saldo' => 0,
        ]);

        return response()->json(compact('member'),201);
    }

    public function getInfo($id)
    {
        $member = Member::where('id', $id)->get();
        return response()->json(new MemberCollection($member), Response::HTTP_OK);
    }

}
