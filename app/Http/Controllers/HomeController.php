<?php

namespace App\Http\Controllers;

use App\User;
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
        return view('templates.default', compact('user'));
    }

    // home staff
    public function staff()
    {
        $user = Auth::user();
        return view('staff.home', compact('user'));
    }

    // hme kasir
    public function kasir()
    {
        $user = Auth::user();
        return view('kasir.home', compact('user'));
    }
}
