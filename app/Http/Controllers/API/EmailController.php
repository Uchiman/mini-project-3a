<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    // kirim kode vertifikasi
    public function sendEmail()
    {
        $user = Auth::user();
        $nama = $user->name;
        $email = $user->email;
        $kode = mt_rand(1000, 9999);

        $user = User::where('email', $email)->first();
        $user->kode = $kode;
        $user->save();
        Mail::to($email)->send(new SendMail($nama, $kode));

        return Response()->json([
            "status" => "Success",
            "message" => "Email berhasil dikirim ke email " . $email,
        ], 200);
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

                return Response()->json([
                    "status" => "Success",
                    "message" => "Vertifikasi email berhasil",
                ], 200);
            } else {
                return Response()->json([
                    "status" => "Failed",
                    "message" => "Kode vertifikasi tidak sesuai",
                ], 400);
            }
        } else {
            return Response()->json([
                "status" => "Failed",
                "message" => "Email sudah di vertifikasi",
            ], 400);
        }
    }
}
