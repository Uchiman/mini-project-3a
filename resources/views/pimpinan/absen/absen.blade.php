@extends('templates.default')

@section('content')

    <div class="col-md-6" style="margin-left: 25%">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    @if (!$kode)
                        Generate Kode Absen
                    @endif
                    @if ($kode)
                        Kode Absen Hari Ini
                    @endif
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('pimpinan.kode-absen') }}" method="POST">
                @csrf
                <div class="card-body">
                    @if (!$kode)
                        <h1 class="text-center">Belum membuat kode absen!</h1>
                    @endif
                    @if ($kode)
                        <h1 class="text-center"> {{ $qr }} </h1>
                        <hr>
                        <h1 class="text-center">{{ $kode->kode }}</h1>
                    @endif
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    @if (!$kode)
                        <button type="submit" class="btn btn-info">Buat Kode Absen</button>
                    @endif
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
