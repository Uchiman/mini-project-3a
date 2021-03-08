@extends('templates.default')

@section('content')
    <div class="container">

        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <a href="#" class="h1" style="margin-left: 7%"><b>Sales</b>Stock</a>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <a href="/kasir/penjualan"><button type="button" class="btn btn-tool">
                                    <i class="fas fa-times"></i>
                                </button></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h5>Kretek, Bantul, Daerah Istimewa Yogyakarta</h5>
                            <h5>Telp. 085678296478</h5>
                            <h5>{{ $penjualan->created_at->format('l, d/m/Y h:i a') }}</h5>
                        </div>
                        <table class="table">
                            <tbody>
                                @foreach ($detail_penjualans as $detail_penjualan)
                                    <tr>
                                        <td>{{ $detail_penjualan->barang->nama ?? 0 }}</td>
                                        <td>{{ number_format($detail_penjualan->barang->harga_jual, 0, ',', '.') }}</td>
                                        <td>x {{ $detail_penjualan->jumlah_barang ?? 0 }}</td>
                                        @if ($penjualan->kode_member != null)
                                            <td>{{ $detail_penjualan->barang->diskon }}%</td>
                                            <td>{{ number_format($detail_penjualan->harga_jual ?? 0, 0, ',', '.') }}
                                        @endif
                                        @if (!$penjualan->kode_member)
                                            <td>{{ number_format($detail_penjualan->harga_jual ?? 0, 0, ',', '.') }}
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-5">
                        </div>
                        <table class="table">
                            <tr>
                                <td>Total Belanja :</td>
                                <td>Rp. {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Total Bayar :</td>
                                <td>Rp. {{ number_format($penjualan->dibayar, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Kembalian :</td>
                                <td>Rp. {{ number_format($penjualan->kembalian, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                        <div class="mt-5">
                        </div>
                        <table class="table">
                            <div class="text-center">
                                <h5>Terima Kasih</h5>
                                <h5>Kasir : {{ $kasir->name }}</h5>
                                <h5>No : {{ $penjualan->created_at->format('dmyhi') . $penjualan->id }}</h5>
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
