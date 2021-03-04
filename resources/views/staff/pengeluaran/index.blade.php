@extends('templates.default')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Data Pengeluaran</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Keterangan</th>
                                    <th>Biaya</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                        <a href="{{ route('pengeluaran.create') }}" class="btn btn-info float-right mt-5"> Tambah
                        </a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

    <form action="" method="post" id="deleteForm">
        @csrf
        @method("DELETE")
        <input type="submit" value="Hapus" style="display: none">
    </form>

@endsection

@push('styles')
    <!-- DataTables -->
    @include('templates.datatable.styles')
@endpush

@push('scripts')
    <!-- Notify -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.notify.min.js') }}"></script>
    @include('templates.partials.alerts')
    <!-- DataTables -->
    @include('templates.datatable.scripts')

    <script>
        $(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('pengeluaran.data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        responsive: true,
                        lengthChange: false,
                        autoWidth: false,
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'biaya'
                    },
                    {
                        data: 'hari'
                    },
                    {
                        data: 'action'
                    },
                ]
            });
        });

    </script>
@endpush
