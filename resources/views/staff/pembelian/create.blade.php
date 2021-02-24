@extends('templates.default')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Input Data Transaksi Pembelian</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('pembelian.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <div class="form-group  @error('supplier') has-error @enderror">
                    <label for="supplier">Supplier</label>
                    <input type="text" class="form-control" id="supplier" name="supplier"
                        placeholder="Masukkan nama supplier" value="{{ old('supplier') }}">
                    @error('supplier')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group @error('barang') has-error @enderror">
                    <label for="">Nama Barang</label>
                    <input type="text" name="barang" class="form-control" placeholder="Masukkan nama barang"
                        value="{{ old('barang') }}">
                    @error('barang')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group @error('total_barang') has-error @enderror">
                    <label for="">Total Barang</label>
                    <input type="text" name="total_barang" class="form-control"
                        placeholder="Masukkan total barang" value="{{ old('total_barang') }}">
                    @error('total_barang')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group @error('total_bayar') has-error @enderror">
                    <label for="">Total Bayar</label>
                    <input type="text" name="total_bayar" class="form-control" placeholder="Masukkan total harga barang"
                        value="{{ old('total_bayar') }}">
                    @error('total_bayar')
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

@endsection
