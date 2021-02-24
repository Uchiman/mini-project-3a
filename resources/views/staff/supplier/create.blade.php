@extends('templates.default')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Input Data Supplier</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <div class="form-group  @error('nama') has-error @enderror">
                    <label for="nama">Nama Toko</label>
                    <input type="text" class="form-control" id="nama" name="nama"
                        placeholder="Masukkan nama toko" value="{{ old('nama') }}">
                    @error('nama')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group @error('alamat') has-error @enderror">
                    <label for="">Alamat Toko</label>
                    <input type="text" name="alamat" class="form-control" placeholder="Masukkan nama alamat"
                        value="{{ old('alamat') }}">
                    @error('alamat')
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
