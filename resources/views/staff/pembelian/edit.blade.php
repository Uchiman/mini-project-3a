@extends('templates.default')

@section('content')

    <div class="col-md-6" style="margin-left: 25%">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Data Transaksi Pembelian</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="/staff/pembelian/{{ $pembelian->id }}" method="POST">
                @csrf
                @method("PUT")
                <div class="card-body">

                    <div class="form-group  @error('supplier') has-error @enderror">
                        <label for="supplier">Supplier</label>
                        <input type="text" class="form-control" id="supplier" name="supplier"
                            placeholder="Masukkan nama supplier" value="{{ old('supplier') ?? $pembelian->supplier }}">
                        @error('supplier')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group @error('barang') has-error @enderror">
                        <label for="barang">Nama Barang</label>
                        <input type="text" name="barang" id="barang" class="form-control" placeholder="Masukkan nama barang"
                            value="{{ old('barang') ?? $pembelian->barang }}">
                        @error('barang')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group @error('total_barang') has-error @enderror">
                        <label for="total_barang">Total Barang</label>
                        <input type="number" name="total_barang" id="total_barang" class="form-control" placeholder="Masukkan total barang"
                            value="{{ old('total_barang') ?? $pembelian->total_barang }}">
                        @error('total_barang')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group @error('total_bayar') has-error @enderror">
                        <label for="total_bayar">Total Bayar</label>
                        <input type="number" name="total_bayar" id="total_bayar" class="form-control" placeholder="Masukkan total harga barang"
                            value="{{ old('total_bayar') ?? $pembelian->total_bayar }}">
                        @error('total_bayar')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group @error('hari') has-error @enderror">
                        <label for="hari">Tanggal Pembelian</label>
                        <input type="text" name="hari" id="hari" class="form-control" placeholder="Masukkan tanggal pembelian barang"
                            value="{{ old('hari') ?? $pembelian->hari }}">
                        @error('hari')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
