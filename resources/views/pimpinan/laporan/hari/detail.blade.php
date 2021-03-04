@extends('templates.default')

@section('content')

    <div class="container-fluid">
        <h1>Laporan Hari {{ $namaHari->created_at->isoFormat('dddd, D MMMM Y') }}</h1>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Rp. {{ $data['pendapatan'] ?? 0 }} x</h3>

                        <p>Pendapatan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Rp. {{ $data['keuntungan'] ?? 0 }}</h3>

                        <p>Keuntungan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="/pimpinan/laporan/bulan/penjualan/{{ $namaHari->bulan }}" class="small-box-footer">More info
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $data['jumlah_barang'] ?? 0 }}</h3>

                        <p>Barang Terjual</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="/pimpinan/laporan/bulan/pengeluaran/{{ $namaHari->hari }}" class="small-box-footer">More info
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
