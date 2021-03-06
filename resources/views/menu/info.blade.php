@extends('templates.default')

@section('content')

    <div class="col-md-8" style="margin-left: 15%">
        <!-- Widget: user widget style 1 -->
        <div class="card card-widget widget-user shadow-lg">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header text-white"
                style="background: url('/assets/dist/img/photo1.png') center center;">
                <h3 class="widget-user-username text-right"> {{ $user->name }} </h3>
                <h5 class="widget-user-desc text-right">{{ $role[0] }}</h5>
            </div>
            <div class="widget-user-image">
                <img class="img-circle" src="{{ asset('assets/dist/img/avatar5.png') }}" alt="User Avatar">
            </div>
            <div class="card-footer">
                <div class="row mt-5">
                    <div class="col-sm-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header">Nama</h5>
                            <span class="text">{{ $user->name }}</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <div class="description-block">
                            <h5 class="description-header">Email*</h5>
                            <span class="text">{{ $user->email }}</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                @role('kasir')
                <div class="row mt-5 mb-5">
                    <div class="col-sm-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header">Umur</h5>
                            <span class="text">{{ $kasir->umur ?? '??' }}</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <div class="description-block">
                            <h5 class="description-header">Alamat</h5>
                            <span class="text">{{ $kasir->alamat ?? '??' }}</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    @endrole
                    <!-- /.row -->
                    <a href="/akun/{{ $user->id }}/edit" class="btn btn-warning">Edit Profil</a>
                </div>
                <div class="float-right">
                    @if ($user->email_verified_at)
                    <p class="small">*Sudah vertifikasi email</p>
                    @endif
                    @if (!$user->email_verified_at)
                    <p class="small">*Belum vertifikasi email</p>
                    <form action="{{ route('akun.kirim-vertifikasi') }}" method="post">
                        @csrf
                        <button type="submit">
                            <p class="small">Kirim Vertifikasi</p>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.widget-user -->
    </div>

@endsection

@push('scripts')

    <!-- Notify -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.notify.min.js') }}"></script>
    @include('templates.partials.alerts')

@endpush
