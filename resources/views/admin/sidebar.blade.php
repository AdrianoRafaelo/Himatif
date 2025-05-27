<!-- Sidebar -->
<style>
    .sidebar {
        min-height: 100vh;
        padding-top: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    .sidebar-brand {
        padding: 1.5rem 0;
        margin-bottom: 1.5rem;
    }
    .sidebar-brand-icon i {
        font-size: 2rem;
        color: #fff;
    }
    .sidebar-brand-text {
        font-size: 1.25rem;
        font-weight: 600;
        color: #fff;
    }
    .sidebar-heading {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 700;
        color: rgba(255,255,255,0.8);
        letter-spacing: 1px;
    }
    .sidebar-divider {
        border-top: 1px solid rgba(255,255,255,0.2);
        margin: 1rem 0;
    }
    .nav-item {
        margin-bottom: 0.5rem;
    }
    .nav-link {
        padding: 0.75rem 1.5rem;
        color: #fff;
        font-weight: 500;
        border-radius: 0.5rem;
        margin: 0 0.5rem;
        transition: background-color 0.2s ease;
    }
    .nav-link:hover {
        background-color: rgba(255,255,255,0.1);
    }
    .nav-link i {
        margin-right: 0.75rem;
        font-size: 1.1rem;
    }
    .collapse-inner {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        margin: 0.5rem 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .collapse-item {
        padding: 0.75rem 1.5rem;
        color: #333;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: background-color 0.2s ease;
    }
    .collapse-item:hover {
        background-color: #e9ecef;
        text-decoration: none;
    }
    .collapse-item i {
        margin-right: 0.75rem;
        color: #007bff;
    }
    #sidebarToggle {
        padding: 0.75rem;
        transition: all 0.3s ease;
    }
    #sidebarToggle:hover {
        background-color: rgba(255,255,255,0.2);
    }
</style>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/admin') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="sidebar-brand-text mx-3">HIMATIF</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/admin/dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Admin and Bendahara Features -->
    <!-- Manajemen Section (Admin, Bendahara, Kaprodi) -->
    @if(session('user')['role'] === 'admin' || session('user')['role'] === 'bendahara' || session('user')['role'] === 'kaprodi')
        <!-- Heading -->
        <div class="sidebar-heading text-uppercase">
            <span class="small font-weight-bold">Manajemen</span>
        </div>

        <!-- Role Management (Admin Only) -->
        @if(session('user')['role'] === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.role.index') }}">
                    <i class="fas fa-fw fa-user-tag"></i>
                    <span>Manajemen Role</span>
                </a>
            </li>
        @endif

        <!-- Program Kerja (Admin: View/Create, Bendahara/Kaprodi: View) -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProker"
                aria-expanded="true" aria-controls="collapseProker">
                <i class="fas fa-fw fa-project-diagram"></i>
                <span>Program Kerja</span>
            </a>
            <div id="collapseProker" class="collapse" aria-labelledby="headingProker" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                    <a class="collapse-item" href="{{ route('proker.index') }}">
                        <i class="fas fa-clipboard-list fa-sm mr-2 text-primary"></i>Daftar Program
                    </a>
                    @if(session('user')['role'] === 'admin')
                        <a class="collapse-item" href="{{ route('proker.create') }}">
                            <i class="fas fa-plus-circle fa-sm mr-2 text-primary"></i>Tambah Program
                        </a>
                    @endif
                </div>
            </div>
        </li>

        <!-- Struktur Organisasi BPH (Admin Only) -->
        @if(session('user')['role'] === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.bph.index') }}">
                    <i class="fas fa-fw fa-sitemap"></i>
                    <span>Struktur Organisasi BPH</span>
                </a>
            </li>
        @endif

        <!-- Uang Kas (Bendahara Only) -->
        @if(session('user')['role'] === 'bendahara')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.kas.index') }}">
                    <i class="fas fa-fw fa-money-bill-wave"></i>
                    <span>Uang Kas</span>
                </a>
            </li>
        @endif

        <!-- Laporan Keuangan (Admin and Bendahara) -->
        @if(session('user')['role'] === 'bendahara')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.keuangan.index') }}">
                    <i class="fas fa-fw fa-file-invoice-dollar"></i>
                    <span>Laporan Keuangan</span>
                </a>
            </li>
        @endif
    @endif

    <!-- Proposal Menu (Admin, Kaprodi, Bendahara) -->
@if(session('user')['role'] === 'admin' || session('user')['role'] === 'kaprodi' || session('user')['role'] === 'bendahara')
        <div id="collapseProker" class="collapse" aria-labelledby="headingProker" data-parent="#accordionSidebar">
                @if(session('user')['role'] === 'admin')
                    <a class="collapse-item" href="{{ route('proker.create') }}">
                        <i class="fas fa-plus fa-sm mr-2 text-primary"></i>Buat Proker
                    </a>
                    <a class="collapse-item" href="{{ route('proker.index') }}">
                        <i class="fas fa-list fa-sm mr-2 text-primary"></i>Daftar Proker
                    </a>
                @elseif(session('user')['role'] === 'bendahara')
                    <a class="collapse-item" href="{{ route('proker.index') }}">
                        <i class="fas fa-list fa-sm mr-2 text-primary"></i>Daftar Proker
                    </a>
                @endif
        </div>
    </li>
@endif
@if(session('user')['role'] === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.campus-students.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data Mahasiswa</span>
                </a>
            </li>
@endif
@if(session('user')['role'] === 'kaprodi')
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.kaprodi.proker.reports') }}">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>Tinjau Berita Acara</span>
    </a>
</li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.keuangan.index') }}">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Laporan Keuangan</span>
        </a>
    </li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.kaprodi.proposals.index') }}">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>Proposal</span>
    </a>
</li>

@endif

    <!-- Admin-Only Features (News, Galeri, Visi Misi) -->
    @if(session('user')['role'] === 'admin')
        <!-- News -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNews"
                aria-expanded="true" aria-controls="collapseNews">
                <i class="fas fa-fw fa-newspaper"></i>
                <span>Berita&Pengumuman</span>
            </a>
            <div id="collapseNews" class="collapse" aria-labelledby="headingNews" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                    <a class="collapse-item" href="{{ route('admin.news.index') }}">
                        <i class="fas fa-eye fa-sm mr-2 text-primary"></i>Lihat daftar
                    </a>
                    <a class="collapse-item" href="{{ route('news.create') }}">
                        <i class="fas fa-plus-circle fa-sm mr-2 text-primary"></i>Tambah 
                    </a>
                </div>
            </div>
        </li>

            <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProposal"
            aria-expanded="true" aria-controls="collapseProposal">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Proposal</span>
        </a>
        <div id="collapseProposal" class="collapse" aria-labelledby="headingProposal" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                <a class="collapse-item" href="{{ route('admin.proposals.index') }}">
                    <i class="fas fa-eye fa-sm mr-2 text-primary"></i>Lihat Proposal
                </a>
                <a class="collapse-item" href="{{ route('admin.proposals.create') }}">
                    <i class="fas fa-plus-circle fa-sm mr-2 text-primary"></i>Tambah Proposal
                </a>
            </div>
        </div>
    </li>

        <!-- Galeri -->
        <li class="nav-item">
            <a class="nav-link collapsed教科

System: collapsed" href="#" data-toggle="collapse" data-target="#collapseGaleri"
                aria-expanded="true" aria-controls="collapseGaleri">
                <i class="fas fa-fw fa-images"></i>
                <span>Galeri</span>
            </a>
            <div id="collapseGaleri" class="collapse" aria-labelledby="headingGaleri" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                    <a class="collapse-item" href="{{ route('admin.galeri.index') }}">
                        <i class="fas fa-eye fa-sm mr-2 text-primary"></i>Lihat Galeri
                    </a>
                    <a class="collapse-item" href="{{ route('admin.galeri.create') }}">
                        <i class="fas fa-plus-circle fa-sm mr-2 text-primary"></i>Buat Galeri
                    </a>
                </div>
            </div>
        </li>

        <!-- Visi Misi -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVisiMisi"
                aria-expanded="true" aria-controls="collapseVisiMisi">
                <i class="fas fa-fw fa-bullseye"></i>
                <span>Visi Misi</span>
            </a>
            <div id="collapseVisiMisi" class="collapse" aria-labelledby="headingVisiMisi" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                    <a class="collapse-item" href="{{ route('admin.tentang.index') }}">
                        <i class="fas fa-eye fa-sm mr-2 text-primary"></i>Lihat Visi & Misi
                    </a>
                    <a class="collapse-item" href="{{ route('admin.tentang.create') }}">
                        <i class="fas fa-plus-circle fa-sm mr-2 text-primary"></i>Buat Visi & Misi
                    </a>
                </div>
            </div>
        </li>

        <!-- Event -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEvent"
                aria-expanded="true" aria-controls="collapseEvent">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Event</span>
            </a>
            <div id="collapseEvent" class="collapse" aria-labelledby="headingEvent" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                    <a class="collapse-item" href="{{ route('admin.event.index') }}">
                        <i class="fas fa-eye fa-sm mr-2 text-primary"></i>Lihat Event
                    </a>
                    <a class="collapse-item" href="{{ route('admin.event.create') }}">
                        <i class="fas fa-plus-circle fa-sm mr-2 text-primary"></i>Tambah Event
                    </a>
                </div>
            </div>
        </li>

        <!-- Daftar Pendaftar -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('registrations.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Daftar Pendaftar</span>
            </a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline mt-3">
        <button class="rounded-circle border-0 bg-light" id="sidebarToggle">
            <i class="fas fa-angle-left text-primary"></i>
        </button>
    </div>

</ul>
<!-- End of Sidebar -->