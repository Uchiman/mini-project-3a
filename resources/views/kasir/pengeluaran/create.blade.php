@extends('templates.default')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Input Data Pengeluaran</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('pengeluaran.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <div class="form-group  @error('keterangan') has-error @enderror">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan"
                        placeholder="Masukkan keterangan pengeluaran ( listrik, bensin, ... ) " value="{{ old('keterangan') }}">
                    @error('keterangan')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group  @error('biaya') has-error @enderror">
                    <label for="biaya">Biaya</label>
                    <input type="text" class="form-control" id="biaya" name="biaya"
                        placeholder="Masukkan biaya pengeluaran" value="{{ old('biaya') }}">
                    @error('biaya')
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
