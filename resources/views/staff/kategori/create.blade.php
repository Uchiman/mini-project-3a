@extends('templates.default')

@section('content')

    <div class="col-md-6" style="margin-left: 25%">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Input Data Supplier</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="card-body">

                    <div class="form-group  @error('nama') has-error @enderror">
                        <label for="nama">Nama Kategori Barang</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan kategori barang"
                            value="{{ old('nama') }}">
                        @error('nama')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
