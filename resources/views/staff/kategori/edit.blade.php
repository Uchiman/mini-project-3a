@extends('templates.default')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Data Kategori</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="/staff/kategori/{{ $kategori->id }}" method="POST">
            @csrf
            @method("PUT")
            <div class="card-body">

                <div class="form-group  @error('nama') has-error @enderror">
                    <label for="nama">Nama Kategori Barang</label>
                    <input type="text" class="form-control" id="nama" name="nama"
                        placeholder="Masukkan nama toko" value="{{ old('nama') ?? $kategori->nama }}">
                    @error('nama')
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
