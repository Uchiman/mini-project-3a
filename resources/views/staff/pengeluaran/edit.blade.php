@extends('templates.default')

@section('content')

    <div class="col-md-6" style="margin-left: 25%">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Data Pengeluaran</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="/staff/pengeluaran/{{ $pengeluaran->id }}" method="POST">
                @csrf
                @method("PUT")
                <div class="card-body">

                    <div class="form-group  @error('keterangan') has-error @enderror">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan"
                            placeholder="Masukkan keterangan pengeluaran ( listrik, bensin, ... ) "
                            value="{{ old('keterangan') ?? $pengeluaran->keterangan }}">
                        @error('keterangan')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group  @error('biaya') has-error @enderror">
                        <label for="biaya">Biaya</label>
                        <input type="number" class="form-control" id="biaya" name="biaya"
                            placeholder="Masukkan biaya pengeluaran ( listrik, bensin, ... ) "
                            value="{{ old('biaya') ?? $pengeluaran->biaya }}">
                        @error('biaya')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group  @error('hari') has-error @enderror">
                        <label for="hari">Hari</label>
                        <input type="text" class="form-control" id="hari" name="hari"
                            placeholder="Masukkan tanggal pengeluaran" value="{{ old('hari') ?? $pengeluaran->hari }}">
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
