@extends('templates.default')

@section('content')
    <div class="box">
        <div class="box-header">

        </div>

        <div class="box-body">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf

                <div class="form-group @error('nama') has-error @enderror">
                    <label for="">Nama Barang</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama barang"
                        value="{{ old('nama') }}">
                    @error('nama')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group @error('harga_beli') has-error @enderror">
                    <label for="">Harga Beli</label>
                    <input type="text" name="harga_beli" class="form-control" placeholder="Masukkan harga beli barang per pcs"
                        value="{{ old('harga_beli') }}">
                    @error('harga_beli')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group @error('harga_jual') has-error @enderror">
                    <label for="">Harga Jual</label>
                    <input type="text" name="harga_jual" class="form-control" placeholder="Masukkan harga jual barang per pcs"
                        value="{{ old('harga_jual') }}">
                    @error('harga_jual')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group @error('kategori') has-error @enderror">
                    <label for="">Kategori</label>
                    <select class="custom-select" @error('kategori_id') is-invalid @enderror id="kategori_id" name="kategori_id" required>
                        <option selected>Masukkan kategori barang ...</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group @error('merek') has-error @enderror">
                    <label for="">Merek</label>
                    <input type="text" name="merek" class="form-control" placeholder="Masukkan merek barang"
                        value="{{ old('merek') }}">
                    @error('merek')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group @error('stok') has-error @enderror">
                    <label for="">Stok</label>
                    <input type="text" name="stok" class="form-control"
                        placeholder="Masukkan jumlah barang yang akan di input" value="{{ old('stok') }}">
                    @error('stok')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group @error('diskon') has-error @enderror">
                    <label for="">Diskon</label>
                    <input type="text" name="diskon" class="form-control" placeholder="Masukkan diskon barang jika ada"
                        value="{{ old('diskon') }}">
                    @error('diskon')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="submit" value="Tambah" class="btn btn-primary">
                </div>

            </form>
        </div>
    </div>
@endsection
