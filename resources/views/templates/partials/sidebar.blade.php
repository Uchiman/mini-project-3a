<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('assets/dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ $user->name }}</a>
        </div>
    </div>

    @role('staff')
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @role('staff')
                    <li class="nav-item">
                        <a href="/staff" class="nav-link active">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dashboard Staff</p>
                        </a>
                    </li>
                    @endrole
                </ul>
            </li>
            <li class="nav-item">
                <a href="/staff/pembelian" class="nav-link">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        Transaksi Pembelian
                        <span class="badge badge-info right"></span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/staff/barang" class="nav-link">
                    <i class="nav-icon fas fa-box"></i>
                    <p>
                        Data Barang
                        <span class="right badge badge-danger"></span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/staff/supplier" class="nav-link">
                    <i class="nav-icon fas fa-truck"></i>
                    <p>
                        Supplier
                        <span class="badge badge-info right"></span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/staff/kategori" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>
                        Kategori
                        <span class="badge badge-info right"></span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/staff/pengeluaran" class="nav-link">
                    <i class="nav-icon fas fa-money-bill"></i>
                    <p>
                        Pengeluaran
                        <span class="badge badge-info right"></span>
                    </p>
                </a>
            </li>
            @endrole

            {{-- DASHBOARD KASIR --}}
            @role('kasir')
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @role('kasir')
                            <li class="nav-item">
                                <a href="/kasir" class="nav-link active">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard Kasir</p>
                                </a>
                            </li>
                            @endrole
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="/kasir/penjualan" class="nav-link">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>
                                Transaksi Penjualan
                                <span class="badge badge-info right"></span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/kasir/member" class="nav-link">
                            <i class="nav-icon fas fa-id-card"></i>
                            <p>
                                Member
                                <span class="badge badge-info right"></span>
                            </p>
                        </a>
                    </li>
                    @endrole

                    {{-- DASHBOARD PIMPINAN --}}
                    @role('pimpinan')
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('pimpinan')
                                    <li class="nav-item">
                                        <a href="/pimpinan" class="nav-link active">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Dashboard Pimpinan</p>
                                        </a>
                                    </li>
                                    @endrole
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-box"></i>
                                    <p>
                                        Laporan Stok
                                        <i class="fas fa-angle-left right"></i>
                                        <span class="badge badge-info right"></span>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/pimpinan/stok/hari" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Harian</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/pimpinan/stok/bulan" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Bulanan</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="/pimpinan/laporan/bulan" class="nav-link">
                                    <i class="nav-icon fas fa-chart-bar"></i>
                                    <p>
                                        Laporan Bulanan
                                        <span class="badge badge-info right"></span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/pimpinan/laporan/hari" class="nav-link">
                                    <i class="nav-icon fas fa-chart-bar"></i>
                                    <p>
                                        Laporan Harian
                                        <span class="badge badge-info right"></span>
                                    </p>
                                </a>
                            </li>

                            @endrole
                            @role('admin')

                            <!-- Sidebar Menu -->
                            <nav class="mt-2">
                                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                                    data-accordion="false">
                                    <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                                    <li class="nav-item menu-open">
                                        <a href="#" class="nav-link active">
                                            <i class="nav-icon fas fa-tachometer-alt"></i>
                                            <p>
                                                Dashboard
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @role('admin')
                                            <li class="nav-item">
                                                <a href="/admin" class="nav-link active">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Dashboard Admin</p>
                                                </a>
                                            </li>
                                            @endrole
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/admin/users" class="nav-link">
                                            <i class="nav-icon fas fa-users"></i>
                                            <p>
                                                User
                                                <span class="badge badge-info right"></span>
                                            </p>
                                        </a>
                                    </li>

                                    @endrole

                                    <li class="nav-header">AKUN SAYA</li>
                                    <li class="nav-item">
                                        <a href="{{ route('akun.index') }}" class="nav-link">
                                            <i class="nav-icon fas fa-user-alt"></i>
                                            <p>Info akun</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href={{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="nav-link">
                                            <i class="nav-icon fas fa-sign-out-alt"></i>
                                            <p>Keluar</p>
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </nav>
                            <!-- /.sidebar-menu -->


</div>
