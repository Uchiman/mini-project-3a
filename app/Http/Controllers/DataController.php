<?php

namespace App\Http\Controllers;

use App\Barang;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function barang()
    {
        $barang = Barang::with('kategori')->orderBy('nama', 'ASC');

        return datatables()->of($barang)
        ->addColumn('action', 'staff.barang.action')
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
    }
}
