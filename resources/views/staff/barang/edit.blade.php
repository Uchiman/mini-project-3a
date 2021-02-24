@extends('templates.default')

@section('content')
    <div class="box">
        <div class="box-header">
        </div>

        <div class="box-body">
            <form action="#" method="POST">
                @csrf
                @method("PUT")

                <div class="form-group @error('jenis') has-error @enderror">
                    <label for="">Nama</label>
                    <input type="text" name="jenis" class="form-control" placeholder="Masukkan jenis barang"
                        value="{{ old('jenis') ?? $barang->nama }}">
                    @error('jenis')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group @error('harga') has-error @enderror">
                    <label for="">Email</label>
                    <input type="text" name="harga" class="form-control" placeholder="Masukkan harga barang"
                        value="{{ old('harga') ?? $barang->harga_jual }}">
                    @error('harga')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="submit" value="Ubah" class="btn btn-primary">
                </div>

            </form>
        </div>
@endsection
