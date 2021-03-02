@extends('templates.default')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Barang</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah Barang</th>
                                <th>Jumlah Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail_penjualans as $detail_penjualan)
                                <tr>
                                    <th>{{ $detail_penjualan->id ?? 0 }}</th>
                                    <th>{{ $detail_penjualan->barang->nama ?? 0 }}</th>
                                    <th>{{ number_format($detail_penjualan->barang->harga_jual, 0, ',', '.') }}</th>
                                    <th>x {{ $detail_penjualan->jumlah_barang ?? 0 }}</th>
                                    <th>{{ number_format(($detail_penjualan->barang->harga_jual ?? 0) * ($detail_penjualan->jumlah_barang ?? 0), 0, ',', '.') }}
                                    </th>
                                    <th> <a href="/kasir/penjualan/{{ $detail_penjualan->id }}/edit"
                                            class="btn btn-warning">Edit</a>
                                        <button href="/kasir/penjualan/{{ $detail_penjualan->id }}" class="btn btn-danger" id="delete">Hapus</button>
                                    </th>
                                </tr>
                            @endforeach
                            <form action="" method="post" id="deleteForm">
                                @csrf
                                @method("DELETE")
                                <input type="submit" value="Hapus" style="display: none">
                            </form>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="" style="margin-left: 85%">
                    @if (count($detail_penjualans) != null)
                        <h5 class="font-weight-bold text-danger"> TOTAL HARGA :
                            {{ $detail_penjualans->sum('harga_jual') ?? 0 }}
                        </h5>
                    @endif
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->

    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Input Barang</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('kasir.store') }}" method="POST">
                        @csrf
                        <div class="card-body">

                            <div class="form-group  @error('kode') has-error @enderror">
                                <label for="kode">Kode Barang</label>
                                <input type="text" class="form-control" id="kode" name="kode"
                                    placeholder="Masukkan kode barang" value="{{ old('kode') }}">
                                @error('kode')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group @error('jumlah_barang') has-error @enderror">
                                <label for="">Jumlah Barang</label>
                                <input type="number" name="jumlah_barang" class="form-control"
                                    placeholder="Masukkan jumlah barang" value="1">
                                @error('jumlah_barang')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->

            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
                <!-- Form Element sizes -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Input Pembayaran</h3>
                    </div>

                    <!-- form start -->
                    <form action="{{ route('kasir2.store') }}" method="POST">
                        @csrf
                        <div class="card-body">

                            <div class="form-group  @error('dibayar') has-error @enderror">
                                <label for="dibayar">Jumlah Uang Pembayaran</label>
                                <input type="number" class="form-control" id="dibayar" name="dibayar"
                                    placeholder="Masukkan nominal uang bayar" value="{{ old('dibayar') }}">
                                @error('dibayar')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group @error('kode_member') has-error @enderror">
                                <label for="">Member</label>
                                <input type="text" name="kode_member" class="form-control"
                                    placeholder="Masukkan kode member ( jika ada )" value="{{ old('kode_member') }}">
                                @error('kode_member')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->

@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.notify.min.js') }}"></script>
    @include('templates.partials.alerts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
        $('button#delete').on('click', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');

            Swal.fire({
                title: 'Apakah kamu yakin hapus data ini?',
                text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus saja!'
            }).then((result) => {
                if (result.value) {
                    document.getElementById('deleteForm').action = href;
                    document.getElementById('deleteForm').submit();
                }
            })
        })

    </script>

@endpush
