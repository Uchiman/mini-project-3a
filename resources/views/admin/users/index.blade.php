@extends('templates.default')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Member</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                        <a href="{{ route('users.create') }}" class="btn btn-info float-right mt-5"> Tambah
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
                ajax: '{{ route('users.data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        responsive: true,
                        lengthChange: false,
                        autoWidth: false,
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'roles[0].name'
                    },
                    {
                        data: 'action'
                    },
                ]
            });
        });

    </script>
@endpush
