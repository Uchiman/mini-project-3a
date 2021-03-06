@extends('templates.default')

@section('content')

    <div class="col-md-6" style="margin-left: 25%">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Data User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="/akun/{{ $user->id }}" method="POST">
                @csrf
                @method("PUT")
                <div class="card-body">

                    <div class="form-group  @error('nama') has-error @enderror">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama user"
                            value="{{ old('nama') ?? $user->name }}">
                        @error('nama')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    @role('kasir')
                    <div class="form-group  @error('umur') has-error @enderror">
                        <label for="umur">Umur</label>
                        <input type="text" class="form-control" id="umur" name="umur" placeholder="Masukkan umur user"
                            value="{{ old('umur') ?? $kasir->umur ?? ""}}">
                        @error('umur')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group  @error('alamat') has-error @enderror">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat user"
                            value="{{ old('alamat') ?? $kasir->alamat ?? ""}}">
                        @error('alamat')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    @endrole
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
