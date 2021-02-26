@extends('templates.default')

@section('content')

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Data Barang</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="/staff/barang/{{ $barang->id }}" method="POST">
                @csrf
                @method("PUT")
                <div class="card-body">

                    <div class="form-group  @error('nama') has-error @enderror">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama barang"
                            value="{{ old('jenis') ?? $barang->nama }}">
                        @error('nama')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group @error('harga_beli') has-error @enderror">
                        <label for="">Harga Beli</label>
                        <input type="text" name="harga_beli" class="form-control"
                            placeholder="Masukkan harga beli barang per pcs"
                            value="{{ old('harga_beli') ?? $barang->harga_beli }}">
                        @error('harga_beli')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group @error('harga_jual') has-error @enderror">
                        <label for="">Harga Jual</label>
                        <input type="text" name="harga_jual" class="form-control"
                            placeholder="Masukkan harga jual barang per pcs"
                            value="{{ old('harga_jual') ?? $barang->harga_jual }}">
                        @error('harga_jual')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control select2" style="width: 100%;" @error('kategori_id') is-invalid @enderror
                            id="kategori_id" name="kategori_id" required>
                            <option selected disabled="selected">Masukkan kategori barang ..</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group @error('merek') has-error @enderror">
                        <label for="">Merek</label>
                        <input type="text" name="merek" class="form-control" placeholder="Masukkan merek barang"
                            value="{{ old('merek') ?? $barang->merek }}">
                        @error('merek')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group @error('stok') has-error @enderror">
                        <label for="">Stok</label>
                        <input type="text" name="stok" class="form-control"
                            placeholder="Masukkan jumlah barang yang akan di input"
                            value="{{ old('stok') ?? $barang->stok }}">
                        @error('stok')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group @error('diskon') has-error @enderror">
                        <label for="">Diskon</label>
                        <input type="text" name="diskon" class="form-control" placeholder="Masukkan diskon barang jika ada"
                            value="{{ old('diskon') ?? $barang->diskon }}">
                        @error('diskon')
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
