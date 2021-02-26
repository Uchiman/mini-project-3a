@extends('templates.default')

@section('content')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Jumlah Barang</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="/kasir/penjualan/{{ $detail_penjualan->id }}" method="POST">
            @csrf
            @method("PUT")
            <div class="card-body">

                <div class="form-group  @error('kode') has-error @enderror">
                    <label for="kode">{{ old('kode')  ?? $barang->nama }}</label>
                </div>

                <div class="form-group @error('jumlah_barang') has-error @enderror">
                    <label for="">Jumlah Barang</label>
                    <input type="number" name="jumlah_barang" class="form-control"
                        placeholder="Masukkan jumlah barang" value="{{ old('jumlah_barang') ?? $detail_penjualan->jumlah_barang }}">
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

@endsection
