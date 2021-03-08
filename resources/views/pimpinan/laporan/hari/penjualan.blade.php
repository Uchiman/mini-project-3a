@extends('templates.default')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Laporan Penjualan Per Hari</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="dataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>ID Penjualan</th>
                                    <th>Tanggal Penjualan</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjualans as $penjualan)
                                    <tr>
                                        <td>{{ $penjualan->id }}</td>
                                        <td>{{ ($penjualan->created_at->format('dmyhi')) . ($penjualan->id) }}</td>
                                        <td>{{ $penjualan->hari }}</td>
                                        <td><a href="/pimpinan/laporan/hari/penjualan/detail/{{ $penjualan->id }}" class="btn btn-info">Info</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    @include('templates.partials.alerts')
    <!-- DataTables -->
    @include('templates.datatable.scripts')

    <script>
        $(function() {
            $("#dataTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false
            });
        });

    </script>
@endpush
