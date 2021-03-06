@extends('templates.default')

@section('content')
    
<div class="col-md-6" style="margin-left: 25%">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Masukan Kode Vertifikasi</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('akun.vertifikasi-email') }}" method="POST">
            @csrf
            <div class="card-body">

                <div class="form-group  @error('kode') has-error @enderror">
                    <label for="kode">Kode Vertifikasi</label>
                    <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan kode vertifikasi email"
                        value="{{ old('kode') }}">
                    @error('kode')
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

@push('scripts')

    <!-- Notify -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.notify.min.js') }}"></script>
    @include('templates.partials.alerts')

@endpush
